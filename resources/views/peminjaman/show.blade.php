@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Detail Peminjaman</h1>
        <small class="text-muted">Informasi lengkap peminjaman #{{ $peminjaman->id_peminjaman }}</small>
    </div>
    <a href="{{ route('mahasiswa.peminjaman.index') }}" class="btn btn-outline-secondary">Kembali</a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Data Barang</h5>
                <p class="mb-1"><strong>Nama:</strong> {{ $peminjaman->barang->nama_barang ?? '-' }}</p>
                <p class="mb-1"><strong>Kode Barang:</strong> {{ $peminjaman->barang->kode_barang ?? '-' }}</p>
                <p class="mb-0"><strong>Status:</strong> {{ ucfirst($peminjaman->status) }}</p>
            </div>
        </div>
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h5 class="card-title">Periode Peminjaman</h5>
                <div class="row">
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Mulai</p>
                        <p class="fw-semibold">{{ \Carbon\Carbon::parse($peminjaman->waktu_awal)->translatedFormat('d F Y H:i') }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="text-muted mb-1">Selesai</p>
                        <p class="fw-semibold">{{ \Carbon\Carbon::parse($peminjaman->waktu_akhir)->translatedFormat('d F Y H:i') }}</p>
                    </div>
                </div>
                <p class="mb-0"><strong>Alasan:</strong> {{ $peminjaman->alasan ?? '-' }}</p>
            </div>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Aktivitas Terkait</h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Keluhan</span>
                        <span class="badge bg-secondary">{{ $peminjaman->keluhan->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Perpanjangan</span>
                        <span class="badge bg-secondary">{{ $peminjaman->perpanjangan->count() }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Serah Terima</span>
                        <span class="badge bg-secondary">{{ $peminjaman->serahTerima->count() }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body text-center">
                <h5 class="card-title">QR Code</h5>
                @if($peminjaman->qr)
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=180x180&data={{ $peminjaman->qr->qr_code }}" alt="QR" class="img-fluid mb-2">
                    <p class="mb-0"><strong>{{ $peminjaman->qr->qr_code }}</strong></p>
                @else
                    <p class="text-muted mb-0">QR belum tersedia.</p>
                @endif
            </div>
        </div>
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Informasi Pengguna</h5>
                <p class="mb-1"><strong>Nama:</strong> {{ $peminjaman->pengguna->nama ?? auth()->user()->name }}</p>
                <p class="mb-0"><strong>Status:</strong> {{ auth()->user()->role }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
