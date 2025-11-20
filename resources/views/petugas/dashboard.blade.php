@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color:#F3F4F6; min-height:100vh;">

    {{-- HEADER --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex justify-content-between align-items-start">
            <div>
                <h1 class="h4 mb-1 fw-bold text-dark">Dashboard Petugas</h1>
                <p class="text-muted mb-0">Selamat datang di panel administrasi sistem peminjaman</p>
            </div>
            <div class="text-end">
                <small id="dashboard-date" class="text-muted d-block">
                    {{ now()->format('l, d F Y') }}
                </small>
                <small id="dashboard-time" class="text-muted">
                    {{ now()->format('H:i') }}
                </small>
            </div>
        </div>
    </div>

    {{-- STATISTIK CARDS --}}
    <div class="row g-3 mb-4">
        {{-- Total Barang (ungu) --}}
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm"
                 style="background: linear-gradient(135deg, #6366F1 0%, #4F46E5 100%); color:#fff;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 opacity-75">Total Barang</h6>
                        <h2 class="mb-0 fw-bold">{{ $totalBarang ?? 0 }}</h2>
                    </div>
                    <div class="ms-3">
                        <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;">
                            <i class="fas fa-box fa-lg opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Barang Tersedia (soft grey/green) --}}
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm" style="background-color:#EEF2FF;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 text-muted">Barang Tersedia</h6>
                        <h2 class="mb-0 fw-bold text-dark">{{ $barangTersedia ?? 0 }}</h2>
                    </div>
                    <div class="ms-3">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;">
                            <i class="fas fa-check-circle fa-lg text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Peminjaman Aktif (soft yellow) --}}
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm" style="background-color:#FFF7E6;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 text-muted">Peminjaman Aktif</h6>
                        <h2 class="mb-0 fw-bold text-dark">{{ $peminjamanAktif ?? 0 }}</h2>
                    </div>
                    <div class="ms-3">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;">
                            <i class="fas fa-hand-holding fa-lg text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Denda Belum Dibayar (soft red) --}}
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm" style="background-color:#FEE2E2;">
                <div class="card-body d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 text-muted">Denda Belum Dibayar</h6>
                        <h2 class="mb-0 fw-bold text-dark">{{ $dendaBelumDibayar ?? 0 }}</h2>
                    </div>
                    <div class="ms-3">
                        <div class="rounded-circle bg-white d-flex align-items-center justify-content-center"
                             style="width:48px;height:48px;">
                            <i class="fas fa-exclamation-triangle fa-lg text-danger"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- QUICK ACTIONS --}}
    <div class="row g-3 mb-4">
        {{-- Manajemen Barang --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-2 text-dark">
                        Manajemen Barang
                    </h5>
                    <p class="text-muted small mb-3">Akses cepat ke fitur barang</p>

                    <div class="d-flex flex-wrap gap-2 mb-2">
                        <a href="{{ route('barang.index') }}"
                           class="btn btn-primary d-flex align-items-center px-3">
                            <i class="fas fa-list me-2"></i>
                            Lihat Barang
                        </a>
                        <a href="{{ route('petugas.barang.create') }}"
                           class="btn btn-outline-primary d-flex align-items-center px-3">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Barang
                        </a>
                    </div>

                    <a href="{{ route('petugas.kategori.index') }}" class="small text-primary text-decoration-none">
                        <i class="fas fa-tags me-1"></i>Kelola Kategori
                    </a>
                </div>
            </div>
        </div>

        {{-- Persetujuan & Service --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-2 text-dark">
                        Persetujuan &amp; Service
                    </h5>
                    <p class="text-muted small mb-3">Kelola perpanjangan dan service barang</p>

                    <div class="d-flex flex-wrap gap-2 mb-2">
                        <a href="{{ route('petugas.perpanjangan.index') }}"
                           class="btn btn-warning d-flex align-items-center px-3">
                            <i class="fas fa-clock me-2"></i>
                            Perpanjangan
                        </a>
                        <a href="{{ route('petugas.serahterima.index') }}"
                           class="btn btn-outline-secondary d-flex align-items-center px-3">
                            <i class="fas fa-handshake me-2"></i>
                            Serah Terima
                        </a>
                    </div>

                    <a href="{{ route('petugas.service.index') }}" class="small text-primary text-decoration-none">
                        <i class="fas fa-tools me-1"></i>Kelola Service
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- AKTIVITAS & STATUS SISTEM --}}
    <div class="row g-3">
        {{-- Aktivitas Terbaru --}}
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-dark">
                        <i class="fas fa-chart-line me-2"></i>Aktivitas Terbaru
                    </h5>
                    <div class="row text-center">
                        <div class="col-6 col-md-3 mb-3 mb-md-0">
                            <div class="p-3">
                                <i class="fas fa-users fa-lg text-primary mb-2"></i>
                                <h4 class="mb-1 fw-bold">{{ $totalPengguna ?? 0 }}</h4>
                                <small class="text-muted">Total Pengguna</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3 mb-md-0">
                            <div class="p-3">
                                <i class="fas fa-exclamation-triangle fa-lg text-danger mb-2"></i>
                                <h4 class="mb-1 fw-bold">{{ $totalKeluhan ?? 0 }}</h4>
                                <small class="text-muted">Keluhan Aktif</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3">
                                <i class="fas fa-undo fa-lg text-success mb-2"></i>
                                <h4 class="mb-1 fw-bold">{{ $pengembalianHariIni ?? 0 }}</h4>
                                <small class="text-muted">Pengembalian Hari Ini</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="p-3">
                                <i class="fas fa-bell fa-lg text-warning mb-2"></i>
                                <h4 class="mb-1 fw-bold">{{ $notifikasiBelumDibaca ?? 0 }}</h4>
                                <small class="text-muted">Notifikasi Baru</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Status Sistem --}}
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <h5 class="fw-bold mb-3 text-dark">
                        <i class="fas fa-calendar-check me-2"></i>Status Sistem
                    </h5>

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
                            <small class="text-muted">
                                Terakhir: {{ now()->subDay()->format('d/m/Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- JAM & TANGGAL REALTIME --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dateEl = document.getElementById('dashboard-date');
        const timeEl = document.getElementById('dashboard-time');

        function updateDateTime() {
            const now = new Date();

            // Tanggal dalam bahasa Indonesia
            const dateOptions = {
                weekday: 'long',
                day: '2-digit',
                month: 'long',
                year: 'numeric'
            };
            dateEl.textContent = now.toLocaleDateString('id-ID', dateOptions);

            // Waktu HH:MM:SS 24 jam
            const timeOptions = {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: false
            };
            timeEl.textContent = now.toLocaleTimeString('id-ID', timeOptions);
        }

        updateDateTime();
        setInterval(updateDateTime, 1000);
    });
</script>
@endsection
