@extends('layouts.app')

@php(
    $isPetugasView = request()->routeIs('barang.index') && auth()->check() && auth()->user()->role === 'petugas'
)

@section('content')
@if($isPetugasView)
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1">Manajemen Barang</h1>
            <small class="text-muted">Kelola stok dan status barang kampus</small>
        </div>
        <a href="{{ route('petugas.barang.create') }}" class="btn btn-primary">Tambah Barang</a>
    </div>
    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Foto</th>
                        <th>Nama</th>
                        <th>Kode</th>
                        <th>Kategori</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Harga</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $item)
                        <tr>
                            <td style="width: 100px;">
                                @if($item->foto_url)
                                    <img src="{{ $item->foto_url }}" alt="Foto {{ $item->nama_barang }}" class="img-thumbnail" style="max-height: 80px; object-fit: cover;">
                                @else
                                    <span class="text-muted small">Belum ada foto</span>
                                @endif
                            </td>
                            <td>{{ $item->nama_barang }}</td>
                            <td>{{ $item->kode_barang }}</td>
                            <td>{{ $item->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ $item->stok ?? 0 }}</td>
                            <td>{{ ucfirst($item->status ?? 'tersedia') }}</td>
                            <td>Rp {{ number_format($item->harga ?? 0,0,',','.') }}</td>
                            <td class="text-end">
                                <a href="{{ route('petugas.barang.edit', $item->id_barang) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                                <form action="{{ route('petugas.barang.destroy', $item->id_barang) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus barang ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Daftar Barang Tersedia</h1>

            <div class="row">
                @forelse($barang ?? $barangs ?? [] as $item)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            @if($item->foto_url)
                                <img src="{{ $item->foto_url }}" class="card-img-top" alt="Foto {{ $item->nama_barang }}" style="height: 180px; object-fit: cover;">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->nama_barang }}</h5>
                                <p class="card-text">{{ \Illuminate\Support\Str::limit($item->deskripsi ?? '-', 100) }}</p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        Kode: {{ $item->kode_barang }}<br>
                                        Stok: {{ $item->stok ?? 0 }}<br>
                                        Status: {{ $item->status ?? 'Tersedia' }}
                                    </small>
                                </p>
                                <a href="{{ route('barang.show', $item->id_barang ?? $item->id ?? '') }}" class="btn btn-primary">Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            Tidak ada barang tersedia saat ini.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endif
@endsection
