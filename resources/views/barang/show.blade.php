@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <h1 class="mb-4">{{ $barang->nama_barang }}</h1>

        @if($barang->foto_url)
            <div class="mb-4">
                <img src="{{ $barang->foto_url }}" alt="Foto {{ $barang->nama_barang }}" class="img-fluid rounded" style="max-height: 320px; object-fit: cover;">
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Detail Barang</h5>
                <table class="table">
                    <tr>
                        <th>Kode Barang</th>
                        <td>{{ $barang->kode_barang }}</td>
                    </tr>
                    <tr>
                        <th>Nama Barang</th>
                        <td>{{ $barang->nama_barang }}</td>
                    </tr>
                    <tr>
                        <th>Deskripsi</th>
                        <td>{{ $barang->deskripsi }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>{{ $barang->kategori->nama_kategori ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Stok</th>
                        <td>{{ $barang->stok ?? 0 }}</td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td>
                            <span class="badge bg-{{ $barang->status == 'tersedia' ? 'success' : 'warning' }}">
                                {{ $barang->status ?? 'Tersedia' }}
                            </span>
                        </td>
                    </tr>
                    @if($barang->harga)
                    <tr>
                        <th>Harga</th>
                        <td>Rp {{ number_format($barang->harga, 0, ',', '.') }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        @auth
            @if(auth()->user()->role === 'mahasiswa')
                @php
                    $sudahPinjam = false; // nanti bisa diisi logic cek peminjaman
                @endphp

                @if(!$sudahPinjam)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Pinjam Barang</h5>
                            <a href="{{ route('mahasiswa.peminjaman.create', ['barang_id' => $barang->id ?? $barang->id_barang]) }}" class="btn btn-success btn-lg w-100">
                                Pinjam Sekarang
                            </a>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body text-center">
                            <h5 class="card-title">QR Code Peminjaman</h5>
                            <img src="{{ asset('images/qr-placeholder.png') }}" alt="QR Code" class="img-fluid mb-3" style="max-width: 200px;">
                            <p>Tunjukkan QR ini saat mengambil barang</p>
                        </div>
                    </div>
                @endif
            @endif
        @else
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Login Diperlukan</h5>
                    <p>Silakan login sebagai mahasiswa untuk meminjam barang.</p>
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                </div>
            </div>
        @endauth
    </div>
</div>
@endsection
