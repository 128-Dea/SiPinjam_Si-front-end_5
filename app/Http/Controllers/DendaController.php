<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DendaController extends Controller
{
    public function index()
    {
        // List semua denda + peminjam + barang
        $denda = Denda::with(['peminjaman.pengguna', 'peminjaman.barang'])
            ->orderByDesc('id_denda')
            ->get();

        return view('denda.index', compact('denda'));
    }

    public function create()
    {
        // Peminjaman yang bisa dipilih untuk dibuat denda
        $peminjaman = Peminjaman::with(['pengguna', 'barang'])->get();

        return view('denda.create', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_peminjaman'   => 'required|exists:peminjaman,id_peminjaman',
            'jenis'           => 'required|in:terlambat,rusak,hilang',
            'total_denda'     => 'nullable|numeric|min:0',
            'menit_terlambat' => 'nullable|integer|min:0',
            'keterangan'      => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::with('barang')->findOrFail($data['id_peminjaman']);

        // Hitung nominal denda otomatis berdasarkan jenis
        switch ($data['jenis']) {
            case 'hilang':
                // Denda hilang = harga barang
                $hargaBarang = optional($peminjaman->barang)->harga ?? 0;
                $data['total_denda'] = $hargaBarang;
                $data['keterangan'] = $data['keterangan']
                    ?? 'Denda kehilangan barang.';
                break;

            case 'terlambat':
                // Denda terlambat = menit terlambat × 1.000
                if (!empty($data['menit_terlambat'])) {
                    $data['total_denda'] = $data['menit_terlambat'] * 1000;
                } else {
                    // fallback kalau menit tidak diisi
                    $data['total_denda'] = $data['total_denda'] ?? 0;
                }

                $data['keterangan'] = $data['keterangan']
                    ?? 'Denda keterlambatan pengembalian.';
                break;

            case 'rusak':
            default:
                // Rusak sudah di-handle di pengembalian → nominal bisa diisi manual
                $data['total_denda'] = $data['total_denda'] ?? 0;
                break;
        }

        // Field tambahan
        unset($data['menit_terlambat']);
        $data['status_pembayaran']   = 'belum';
        $data['metode_pembayaran']   = null;
        $data['bukti_transfer_path'] = null;

        Denda::create($data);

        return redirect()->route('petugas.denda.index')
            ->with('success', 'Denda berhasil ditambahkan');
    }

    public function edit(Denda $denda)
    {
        $denda->load(['peminjaman.pengguna', 'peminjaman.barang']);

        return view('denda.edit', compact('denda'));
    }

    public function update(Request $request, Denda $denda)
    {
        $data = $request->validate([
            'status_pembayaran' => 'required|in:belum,sudah',
            'metode_pembayaran' => 'required|in:cash,transfer',
            'bukti_transfer'    => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Validasi tambahan: jika metode transfer, bukti wajib ada
        if ($data['metode_pembayaran'] === 'transfer' && !$request->hasFile('bukti_transfer') && !$denda->bukti_transfer_path) {
            return back()->withErrors(['bukti_transfer' => 'Bukti transfer wajib diupload untuk metode pembayaran transfer.']);
        }

        // Update metode pembayaran
        $denda->metode_pembayaran = $data['metode_pembayaran'];

        // Update status pembayaran
        $denda->status_pembayaran = $data['status_pembayaran'];

        // Upload bukti transfer (jika transfer & file dikirim)
        if ($request->hasFile('bukti_transfer')) {
            if ($denda->bukti_transfer_path) {
                Storage::disk('public')->delete($denda->bukti_transfer_path);
            }

            $path = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
            $denda->bukti_transfer_path = $path;
        }

        $denda->save();

        return redirect()->route('petugas.denda.index')
            ->with('success', 'Data pembayaran denda diperbarui');
    }
}
