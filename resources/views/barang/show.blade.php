@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color:#F3F4F6;">
    <div class="row">
        <div class="col-md-8 mb-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div>
                    <p class="text-muted small mb-1">
                        <a href="{{ route('barang.index') }}" class="text-decoration-none text-muted">
                            Barang
                        </a> /
                        <span class="text-dark fw-semibold">{{ $barang->nama_barang }}</span>
                    </p>
                    <h1 class="h4 mb-0 fw-bold">{{ $barang->nama_barang }}</h1>
                </div>
            </div>

            @if($barang->foto_url)
                <div class="mb-3">
                    <img src="{{ $barang->foto_url }}"
                         alt="Foto {{ $barang->nama_barang }}"
                         class="img-fluid rounded shadow-sm"
                         style="max-height: 320px; object-fit: cover;">
                </div>
            @endif

            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3">Detail Barang</h5>
                    <table class="table table-sm mb-0">
                        <tr>
                            <th style="width:180px;">Kode Barang</th>
                            <td>{{ $barang->kode_barang }}</td>
                        </tr>
                        <tr>
                            <th>Nama Barang</th>
                            <td>{{ $barang->nama_barang }}</td>
                        </tr>
                        <tr>
                            <th>Kategori</th>
                            <td>{{ $barang->kategori->nama_kategori ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Deskripsi</th>
                            <td>{{ $barang->deskripsi ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>
                                @if($barang->harga)
                                    Rp {{ number_format($barang->harga, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status Sistem</th>
                            <td>
                                @php $status = $barang->status_otomatis; @endphp
                                @if($status === 'tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @elseif($status === 'dipinjam')
                                    <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                                @elseif($status === 'service')
                                    <span class="badge bg-info text-dark">Sedang Service</span>
                                @elseif($status === 'habis')
                                    <span class="badge bg-secondary">Stok Habis</span>
                                @else
                                    <span class="badge bg-danger">{{ ucfirst($status) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Status Manual (DB)</th>
                            <td>{{ $barang->status ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Panel kanan: ringkasan stok & aksi cepat --}}
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Ringkasan Stok</h5>
                    <table class="table table-sm mb-0">
                        <tr>
                            <th style="width:160px;">Stok Total</th>
                            <td class="text-end fw-semibold">{{ $barang->stok ?? 0 }}</td>
                        </tr>
                        <tr>
                            <th>Sedang Dipinjam</th>
                            <td class="text-end">{{ $barang->stok_dipinjam }}</td>
                        </tr>
                        <tr>
                            <th>Sedang Service</th>
                            <td class="text-end">{{ $barang->stok_service }}</td>
                        </tr>
                        <tr>
                            <th>Stok Tersedia</th>
                            <td class="text-end fw-bold">{{ $barang->stok_tersedia }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @auth
                @if(auth()->user()->role === 'petugas')
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Manajemen Stok</h5>
                            <p class="small text-muted">
                                Atur stok total barang ini. Status otomatis akan mengikuti stok & transaksi.
                            </p>
                            <div class="d-flex gap-2 mb-2">
                                <form action="{{ route('petugas.barang.stok.kurang', $barang->id_barang) }}"
                                      method="POST" class="flex-fill">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="jumlah" value="1">
                                    <button class="btn btn-outline-secondary w-100" type="submit">
                                        − 1 Stok
                                    </button>
                                </form>
                                <form action="{{ route('petugas.barang.stok.tambah', $barang->id_barang) }}"
                                      method="POST" class="flex-fill">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="jumlah" value="1">
                                    <button class="btn btn-outline-secondary w-100" type="submit">
                                        + 1 Stok
                                    </button>
                                </form>
                            </div>

                            <a href="{{ route('petugas.barang.edit', $barang->id_barang) }}"
                               class="btn btn-primary w-100">
                                Edit Detail Barang
                            </a>
                        </div>
                    </div>
                @else
                    {{-- Untuk mahasiswa: tombol pinjam --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Pinjam Barang</h5>
                            @if($barang->status_otomatis === 'tersedia')
                                <a href="{{ route('mahasiswa.peminjaman.create', ['barang_id' => $barang->id_barang]) }}"
                                   class="btn btn-success btn-lg w-100">
                                    Pinjam Sekarang
                                </a>
                            @else
                                <div class="alert alert-warning mb-0">
                                    Barang ini tidak tersedia untuk dipinjam saat ini.
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            @else
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-2">Login Diperlukan</h5>
                        <p class="small mb-3">
                            Silakan login sebagai mahasiswa untuk meminjam barang.
                        </p>
                        <a href="{{ route('login') }}" class="btn btn-primary w-100">Login</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</div>
@endsection
