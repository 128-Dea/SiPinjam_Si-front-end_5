@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1 fw-bold text-dark">Dashboard Petugas</h1>
            <p class="text-muted mb-0">Selamat datang di panel administrasi sistem peminjaman</p>
        </div>
        <div class="text-end">
            <small class="text-muted d-block">{{ now()->format('l, d F Y') }}</small>
            <small class="text-muted">{{ now()->format('H:i') }}</small>
        </div>
    </div>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-modern h-100 border-0" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-1 opacity-75">Total Barang</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalBarang ?? 0 }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-box fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-modern h-100 border-0" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-1 opacity-75">Barang Tersedia</h6>
                        <h2 class="mb-0 fw-bold">{{ $barangTersedia ?? 0 }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-check-circle fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-modern h-100 border-0" style="background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%); color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-1 opacity-75">Peminjaman Aktif</h6>
                        <h2 class="mb-0 fw-bold">{{ $peminjamanAktif ?? 0 }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-hand-holding fa-2x opacity-75"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card card-modern h-100 border-0" style="background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%); color: white;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="card-title mb-1 opacity-75">Denda Belum Dibayar</h6>
                        <h2 class="mb-0 fw-bold">{{ $dendaBelumDibayar ?? 0 }}</h2>
                    </div>
                    <div class="ms-3">
                        <i class="fas fa-exclamation-triangle fa-2x opacity-75"></i>
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
                        <i class="fas fa-cogs me-2"></i>Manajemen Barang
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('barang.index') }}" class="btn btn-modern btn-primary w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-list me-2"></i>
                                <span>Lihat Barang</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('petugas.barang.create') }}" class="btn btn-modern btn-success w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-plus me-2"></i>
                                <span>Tambah Barang</span>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('petugas.kategori.index') }}" class="btn btn-modern btn-info w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-tags me-2"></i>
                                <span>Kelola Kategori</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card card-modern h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold text-warning">
                        <i class="fas fa-tasks me-2"></i>Persetujuan & Service
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('petugas.perpanjangan.index') }}" class="btn btn-modern btn-warning w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-clock me-2"></i>
                                <span>Perpanjangan</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('petugas.serahterima.index') }}" class="btn btn-modern btn-secondary w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-handshake me-2"></i>
                                <span>Serah Terima</span>
                            </a>
                        </div>
                        <div class="col-12">
                            <a href="{{ route('petugas.service.index') }}" class="btn btn-modern btn-dark w-100 d-flex align-items-center justify-content-center">
                                <i class="fas fa-tools me-2"></i>
                                <span>Kelola Service</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activities & Quick Stats -->
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card card-modern">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-chart-line me-2"></i>Aktivitas Terbaru
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-3">
                            <div class="p-3">
                                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                                <h4 class="mb-1">{{ $totalPengguna ?? 0 }}</h4>
                                <small class="text-muted">Total Pengguna</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-3">
                                <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                                <h4 class="mb-1">{{ $totalKeluhan ?? 0 }}</h4>
                                <small class="text-muted">Keluhan Aktif</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-3">
                                <i class="fas fa-undo fa-2x text-success mb-2"></i>
                                <h4 class="mb-1">{{ $pengembalianHariIni ?? 0 }}</h4>
                                <small class="text-muted">Pengembalian Hari Ini</small>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-3">
                                <i class="fas fa-bell fa-2x text-warning mb-2"></i>
                                <h4 class="mb-1">{{ $notifikasiBelumDibaca ?? 0 }}</h4>
                                <small class="text-muted">Notifikasi Baru</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="card card-modern">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold text-dark">
                        <i class="fas fa-calendar-check me-2"></i>Status Sistem
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-circle text-success me-3"></i>
                        <div>
                            <div class="fw-semibold">Sistem Aktif</div>
                            <small class="text-muted">Semua layanan berjalan normal</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="fas fa-circle text-info me-3"></i>
                        <div>
                            <div class="fw-semibold">Database</div>
                            <small class="text-muted">Koneksi stabil</small>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-circle text-warning me-3"></i>
                        <div>
                            <div class="fw-semibold">Backup</div>
                            <small class="text-muted">Terakhir: {{ now()->subDay()->format('d/m/Y') }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
