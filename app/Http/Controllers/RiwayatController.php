<?php

namespace App\Http\Controllers;

use App\Models\Riwayat;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = Riwayat::with([
                'pengembalian.peminjaman.pengguna',
                'pengembalian.peminjaman.barang',
                'pengembalian.peminjaman.denda',
            ])->orderByDesc('id_riwayat')->get();

        return view('riwayat.index', compact('riwayat'));
    }

    public function show(Riwayat $riwayat)
    {
        $riwayat->load(['pengembalian.peminjaman.pengguna', 'pengembalian.peminjaman.barang', 'pengembalian.peminjaman.denda']);

        return view('riwayat.show', compact('riwayat'));
    }

    /**
     * Histori transaksi untuk petugas (peminjaman selesai).
     */
    public function petugas(Request $request)
    {
        $pengembalian = $this->queryHistory($request)->get();

        $filters = [
            'from'     => $request->query('from'),
            'to'       => $request->query('to'),
            'kondisi'  => $request->query('kondisi'),
            'search'   => $request->query('search'),
        ];

        $totalDenda = $pengembalian->reduce(function ($carry, $item) {
            return $carry + ($item->peminjaman?->denda?->sum('total_denda') ?? 0);
        }, 0);

        return view('riwayat.petugas', compact('pengembalian', 'filters', 'totalDenda'));
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $pengembalian = $this->queryHistory($request)->get();
        $filename = 'histori-transaksi.csv';

        return response()->streamDownload(function () use ($pengembalian) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Nama Mahasiswa', 'Barang', 'Tanggal Pinjam', 'Tanggal Pengembalian', 'Kondisi', 'Total Denda']);
            foreach ($pengembalian as $item) {
                $p = $item->peminjaman;
                $nama = $p?->pengguna?->nama ?? '-';
                $barang = $p?->barang?->nama_barang ?? '-';
                $pinjam = $p?->waktu_awal;
                $kembali = $item->waktu_pengembalian;
                $kondisi = $p?->barang?->status ?? 'baik';
                $denda = $p?->denda?->sum('total_denda') ?? 0;
                fputcsv($handle, [
                    $nama,
                    $barang,
                    $pinjam,
                    $kembali,
                    $kondisi,
                    $denda,
                ]);
            }
            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    public function exportHtml(Request $request)
    {
        $pengembalian = $this->queryHistory($request)->get();
        $totalDenda = $pengembalian->reduce(function ($carry, $item) {
            return $carry + ($item->peminjaman?->denda?->sum('total_denda') ?? 0);
        }, 0);

        $html = view('riwayat.export', compact('pengembalian', 'totalDenda'))->render();

        return response()->streamDownload(function () use ($html) {
            echo $html;
        }, 'histori-transaksi.html', [
            'Content-Type' => 'text/html',
        ]);
    }

    protected function queryHistory(Request $request)
    {
        return Pengembalian::with([
                'peminjaman.pengguna',
                'peminjaman.barang',
                'peminjaman.denda',
            ])
            ->whereHas('peminjaman', function ($q) {
                $q->where('status', 'selesai');
            })
            ->when($request->query('from'), function ($q, $from) {
                $q->whereDate('waktu_pengembalian', '>=', $from);
            })
            ->when($request->query('to'), function ($q, $to) {
                $q->whereDate('waktu_pengembalian', '<=', $to);
            })
            ->when($request->query('kondisi'), function ($q, $kondisi) {
                $q->whereHas('peminjaman.barang', function ($qq) use ($kondisi) {
                    $qq->where('status', $kondisi);
                });
            })
            ->when($request->query('search'), function ($q, $search) {
                $q->where(function ($qq) use ($search) {
                    $qq->whereHas('peminjaman.pengguna', function ($qqq) use ($search) {
                        $qqq->where('nama', 'like', "%{$search}%");
                    })->orWhereHas('peminjaman.barang', function ($qqq) use ($search) {
                        $qqq->where('nama_barang', 'like', "%{$search}%");
                    });
                });
            })
            ->orderByDesc('waktu_pengembalian');
    }
}
