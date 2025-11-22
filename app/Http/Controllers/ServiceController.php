<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Halaman Service untuk PETUGAS:
     * - List barang yang sedang / pernah diservice
     * - Tampilkan rincian kerusakan (dari keluhan)
     * - Tanggal masuk & estimasi selesai
     * - Update status (proses / selesai)
     */
    public function index()
    {
        $service = Service::with([
                'keluhan.peminjaman.barang',
                'keluhan.peminjaman.pengguna',
            ])
            ->orderByDesc('id_service')
            ->get();

        return view('service.index', compact('service'));
    }

    /**
     * Update status service + tanggal-tanggal.
     * Jika status = selesai => barang dikembalikan ke stok (status = tersedia).
     */
    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'status'             => 'required|in:proses,selesai',
            'tgl_masuk_service'  => 'nullable|date',
            'estimasi_selesai'   => 'nullable|date',
        ]);

        // Simpan data ke tabel service
        $service->fill($data);
        $service->save();

        // Sinkronkan status barang (kembalikan ke stok jika selesai)
        $keluhan = $service->keluhan;

        if ($keluhan && $keluhan->peminjaman && $keluhan->peminjaman->barang) {
            $barang = $keluhan->peminjaman->barang;

            if ($data['status'] === 'selesai') {
                // Barang kembali tersedia untuk dipinjam
                $barang->update(['status' => 'tersedia']);
            }
        }

        return redirect()
            ->route('petugas.service.index')
            ->with('success', 'Data service berhasil diperbarui.');
    }
}
