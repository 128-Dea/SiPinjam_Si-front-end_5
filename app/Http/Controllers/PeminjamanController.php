<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Riwayat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PengembalianController extends Controller
{
    public function index()
    {
        // Dipakai oleh PETUGAS: lihat semua pengembalian
        $pengembalian = Pengembalian::with(['peminjaman.pengguna', 'peminjaman.barang'])
            ->orderByDesc('waktu_pengembalian')
            ->get();

        return view('pengembalian.index', compact('pengembalian'));
    }

    public function create()
    {
        // Form pengembalian (dipakai MAHASISWA)
        $query = Peminjaman::with(['barang', 'pengguna'])
            ->whereDoesntHave('pengembalian'); // hanya yang belum dikembalikan

        // Kalau role mahasiswa: hanya peminjaman miliknya
        if (auth()->user()->role === 'mahasiswa') {
            $query->whereHas('pengguna', function ($q) {
                $q->where('id', auth()->id());
            });
        }

        $peminjaman = $query->get();

        return view('pengembalian.create', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_peminjaman'      => 'required|exists:peminjaman,id_peminjaman',
            'waktu_pengembalian' => 'required|date',
            'catatan'            => 'nullable|string',
            'biaya_rusak'        => 'nullable|numeric|min:0',
            'biaya_hilang'       => 'nullable|numeric|min:0',
        ]);

        $peminjaman = Peminjaman::with(['barang', 'pengguna'])->findOrFail($data['id_peminjaman']);

        // Kalau mahasiswa, pastikan peminjaman itu benar punya dia
        if (auth()->user()->role === 'mahasiswa') {
            // SESUAIKAN jika id-nya bukan "id"
            if (!$peminjaman->pengguna || $peminjaman->pengguna->id !== auth()->id()) {
                abort(403, 'Anda tidak boleh mengembalikan peminjaman milik orang lain.');
            }
        }

        DB::transaction(function () use ($data, $peminjaman) {
            $pengembalian = Pengembalian::create([
                'id_peminjaman'      => $data['id_peminjaman'],
                'waktu_pengembalian' => $data['waktu_pengembalian'],
                'catatan'            => $data['catatan'] ?? null,
            ]);

            // Hitung denda terlambat
            $waktuAkhir        = strtotime($peminjaman->waktu_akhir);
            $waktuPengembalian = strtotime($data['waktu_pengembalian']);
            $terlambatMenit    = max(0, ($waktuPengembalian - $waktuAkhir) / 60);
            $dendaTerlambat    = $terlambatMenit * 1000; // 1000 per menit

            $totalDenda = $dendaTerlambat;

            if (!empty($data['biaya_rusak'])) {
                $totalDenda += $data['biaya_rusak'];
            }

            if (!empty($data['biaya_hilang'])) {
                $totalDenda += $data['biaya_hilang'];
            }

            if ($totalDenda > 0) {
                Denda::create([
                    'id_peminjaman'     => $peminjaman->id_peminjaman,
                    'jenis'             => 'pengembalian',
                    'total_denda'       => $totalDenda,
                    'status_pembayaran' => 'belum_dibayar',
                    'keterangan'        => 'Denda pengembalian barang',
                ]);
            }

            // Nonaktifkan QR
            if ($peminjaman->qr) {
                $peminjaman->qr->update(['is_active' => false]);
            }

            // Update status peminjaman & barang
            $peminjaman->update(['status' => 'selesai']);

            if ($peminjaman->barang) {
                $peminjaman->barang->increment('stok');
                $peminjaman->barang->refresh();

                if (in_array($peminjaman->barang->status, ['tersedia', 'dipinjam'])) {
                    $peminjaman->barang->update([
                        'status' => $peminjaman->barang->stok > 0 ? 'tersedia' : 'dipinjam',
                    ]);
                }
            }

            // Simpan ke tabel riwayat
            Riwayat::create([
                'id_pengembalian' => $pengembalian->id_pengembalian,
                'serah_terima'    => 'tidak',
                'denda'           => $totalDenda,
            ]);
        });

        // Redirect sesuai role
        if (auth()->user()->role === 'mahasiswa') {
            return redirect()
                ->route('mahasiswa.riwayat.index')
                ->with('success', 'Pengembalian berhasil dikirim, menunggu verifikasi petugas.');
        }

        return redirect()
            ->route('petugas.pengembalian.index')
            ->with('success', 'Pengembalian berhasil diproses');
    }
}
