@extends('layouts.app')

@php($statistik = $statistik ?? [])
@php($aktivitas = $aktivitas ?? [])
@php($barangDipinjam = $barangDipinjam ?? collect())

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">Dashboard Mahasiswa</h1>
            <p class="text-muted mb-0">Ringkasan aktivitas peminjaman pribadi Anda</p>
        </div>
        <div class="text-end">
            <small class="text-muted d-block" id="current-date">{{ now()->format('l, d F Y') }}</small>
            <small class="text-muted" id="current-time">{{ now()->format('H:i') }}</small>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-modern h-100 border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-1 opacity-75">Peminjaman Aktif</h6>
                        <h2 class="mb-0 fw-bold">{{ $statistik['aktif'] ?? 0 }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-hand-holding fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-modern h-100 border-0" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-1 opacity-75">Menunggu Persetujuan</h6>
                        <h2 class="mb-0 fw-bold">{{ $statistik['menunggu'] ?? 0 }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-clock fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card card-modern h-100 border-0" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-1 opacity-75">Riwayat Selesai</h6>
                        <h2 class="mb-0 fw-bold">{{ $statistik['selesai'] ?? 0 }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-lg-6 mb-4">
            <div class="card card-modern h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="fas fa-plus-circle me-2"></i>Peminjaman & Keluhan
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('mahasiswa.peminjaman.create') }}" class="btn btn-modern btn-primary w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-plus me-2"></i>
                                <span>Ajukan Peminjaman</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('mahasiswa.keluhan.create') }}" class="btn btn-modern btn-warning w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <span>Buat Keluhan</span>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('mahasiswa.peminjaman.index') }}" class="btn btn-modern btn-info w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-list me-2"></i>
                                <span>Lihat Peminjaman</span>
                            </a>
                        </div>

                        {{-- Tombol tambahan: Pengembalian Barang --}}
                        <div class="col-12">
                            <a href="{{ route('mahasiswa.pengembalian.create') }}" class="btn btn-modern btn-outline-primary w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-undo me-2"></i>
                                <span>Pengembalian Barang</span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card card-modern h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold text-success">
                        <i class="fas fa-history me-2"></i>Riwayat & Status
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('mahasiswa.riwayat.index') }}" class="btn btn-modern btn-success w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-history me-2"></i>
                                <span>Riwayat</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('mahasiswa.keluhan.index') }}" class="btn btn-modern btn-secondary w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-comments me-2"></i>
                                <span>Keluhan Saya</span>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="#" class="btn btn-modern btn-dark w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-user me-2"></i>
                                <span>Profile</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Current Borrowings -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card card-modern">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-box me-2"></i>Barang yang Sedang Dipinjam
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($barangDipinjam as $peminjaman)
                        <div class="d-flex align-items-center mb-3 p-3 border rounded">
                            @if(optional($peminjaman->barang)->foto_url)
                                <img src="{{ $peminjaman->barang->foto_url }}" alt="Foto {{ $peminjaman->barang->nama_barang }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px;">
                                    <i class="fas fa-image"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1">
                                <h6 class="mb-1">{{ $peminjaman->barang->nama_barang ?? '-' }}</h6>
                                <small class="text-muted d-block">
                                    Kode: {{ $peminjaman->barang->kode_barang ?? '-' }} |
                                    Kategori: {{ $peminjaman->barang->kategori->nama_kategori ?? '-' }}
                                </small>
                                <small class="text-muted d-block">
                                    Pinjam: {{ \Carbon\Carbon::parse($peminjaman->waktu_awal)->format('d M Y H:i') }} |
                                    Kembali: {{ \Carbon\Carbon::parse($peminjaman->waktu_akhir)->format('d M Y H:i') }}
                                </small>
                            </div>
                            <span class="badge bg-success">{{ $peminjaman->status }}</span>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-box-open fa-3x mb-3 opacity-50"></i>
                            <p>Anda belum memiliki barang yang sedang dipinjam.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card card-modern">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-chart-line me-2"></i>Aktivitas Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    @forelse($aktivitas as $item)
                        <div class="mb-3 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <strong class="d-block">{{ $item['judul'] }}</strong>
                                    <small class="text-muted">{{ $item['deskripsi'] }}</small>
                                </div>
                                <small class="text-muted ms-2">{{ $item['waktu'] }}</small>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                            <p>Belum ada aktivitas terbaru.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const dateEl = document.getElementById('current-date');
    const timeEl = document.getElementById('current-time');

    function updateTime() {
        const now = new Date();
        if (dateEl) {
            dateEl.textContent = now.toLocaleDateString('id-ID', {
                weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
            });
        }
        if (timeEl) {
            timeEl.textContent = now.toLocaleTimeString('id-ID', {
                hour12: false, hour: '2-digit', minute: '2-digit'
            });
        }
    }

    updateTime();
    setInterval(updateTime, 1000);
});
</script>
@endpush
