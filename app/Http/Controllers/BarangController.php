<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends Controller
{
     // Petugas : lihat semua barang + filter status + search
     // Mahasiswa : hanya barang dengan status_otomatis 'tersedia'
    public function index(Request $request)
    {
        $user = auth()->user();

        // Relasi dimuat supaya perhitungan stok otomatis tidak N+1 query
        $query = Barang::with(['kategori', 'peminjaman', 'service']);

        // Pencarian nama / kode barang
        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%');
            });
        }

        // PETUGAS
        if ($user && $user->role === 'petugas') {
            $barang = $query->get();

            // Filter status (hanya tersedia, dipinjam, service)
            $statusFilter = $request->input('status');
            if ($statusFilter && in_array($statusFilter, ['tersedia', 'dipinjam', 'service'], true)) {
                $barang = $barang
                    ->filter(function (Barang $item) use ($statusFilter) {
                        return $item->status_otomatis === $statusFilter;
                    })
                    ->values();
            }
        } else {
            // MAHASISWA / user lain: hanya yang benar-benar tersedia
            $barang = $query->get()
                ->filter(function (Barang $item) {
                    return $item->status_otomatis === 'tersedia';
                })
                ->values();
        }

        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $kategori = Kategori::all();

        return view('barang.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'nama_barang' => 'required|string|max:100',
            'kode_barang' => 'nullable|string|max:20|unique:barang,kode_barang',
            'harga'       => 'nullable|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'foto_barang' => 'nullable|image|max:2048',
        ]);

        $data['kode_barang'] = ($data['kode_barang'] ?? null) ?: $this->generateKodeBarang();
        $data['harga']       = $data['harga'] ?? null;
        $data['status']      = $data['stok'] > 0 ? 'tersedia' : 'habis';

        if ($request->hasFile('foto_barang')) {
            $data['foto_path'] = $request->file('foto_barang')->store('barang', 'public');
        }

        Barang::create($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil ditambahkan');
    }

    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'peminjaman', 'service']);

        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $kategori = Kategori::all();

        return view('barang.edit', compact('barang', 'kategori'));
    }

    public function update(Request $request, Barang $barang)
    {
        $data = $request->validate([
            'id_kategori' => 'required|exists:kategori,id_kategori',
            'nama_barang' => 'required|string|max:100',
            'kode_barang' => 'nullable|string|max:20|unique:barang,kode_barang,' . $barang->id_barang . ',id_barang',
            'harga'       => 'nullable|numeric|min:0',
            'stok'        => 'required|integer|min:0',
            'deskripsi'   => 'nullable|string',
            'foto_barang' => 'nullable|image|max:2048',
        ]);

        $data['kode_barang'] = ($data['kode_barang'] ?? null)
            ?: ($barang->kode_barang ?? $this->generateKodeBarang());

        $data['harga'] = $data['harga'] ?? $barang->harga;
        $data['stok']  = $data['stok'] ?? $barang->stok;

        // Status manual hanya untuk status khusus (rusak/hilang/nonaktif)
        if (!in_array($barang->status, ['rusak', 'hilang', 'nonaktif'], true)) {
            $data['status'] = $data['stok'] > 0 ? 'tersedia' : 'habis';
        } else {
            $data['status'] = $barang->status;
        }

        if ($request->hasFile('foto_barang')) {
            if ($barang->foto_path) {
                Storage::disk('public')->delete($barang->foto_path);
            }
            $data['foto_path'] = $request->file('foto_barang')->store('barang', 'public');
        }

        $barang->update($data);

        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }

    public function destroy(Barang $barang)
    {
        if ($barang->foto_path) {
            Storage::disk('public')->delete($barang->foto_path);
        }

        $barang->delete();

        return redirect()->route('barang.index')->with('success', 'Barang berhasil dihapus');
    }

    // ====== MANAJEMEN STOK CEPAT (PETUGAS) ======

    public function stokTambah(Request $request, Barang $barang)
    {
        $jumlah = max(1, (int) $request->input('jumlah', 1));

        $barang->stok = (int) $barang->stok + $jumlah;

        if (!in_array($barang->status, ['rusak', 'hilang', 'nonaktif'], true) && $barang->stok > 0) {
            $barang->status = 'tersedia';
        }

        $barang->save();

        return back()->with('success', 'Stok barang berhasil ditambah.');
    }

    public function stokKurang(Request $request, Barang $barang)
    {
        $jumlah = max(1, (int) $request->input('jumlah', 1));

        $barang->stok = max(0, (int) $barang->stok - $jumlah);

        if (!in_array($barang->status, ['rusak', 'hilang', 'nonaktif'], true) && $barang->stok === 0) {
            $barang->status = 'habis';
        }

        $barang->save();

        return back()->with('success', 'Stok barang berhasil dikurangi.');
    }

    // ====== HELPER ======

    private function generateKodeBarang(): string
    {
        $nextNumber = (Barang::max('id_barang') ?? 0) + 1;

        return 'BRG-' . str_pad((string) $nextNumber, 4, '0', STR_PAD_LEFT);
    }
}
