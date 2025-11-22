@extends('layouts.app')

@php
    $isPetugasView = request()->routeIs('barang.index')
        && auth()->check()
        && auth()->user()->role === 'petugas';
@endphp

@section('content')
<div class="container-fluid py-4" style="background-color:#F3F4F6; min-height:100vh;">

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if($isPetugasView)
        {{-- ====== VIEW PETUGAS: TABEL MANAJEMEN BARANG ====== --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <p class="text-muted small mb-1">
                    Dashboard /
                    <span class="text-dark fw-semibold">Manajemen Barang</span>
                </p>
                <h1 class="h4 mb-1 fw-bold text-dark">Manajemen Barang</h1>
                <small class="text-muted">
                    Kelola stok, status, dan detail barang inventaris kampus
                </small>
            </div>
            <a href="{{ route('petugas.barang.create') }}" class="btn btn-primary d-flex align-items-center shadow-sm">
                <i class="fas fa-plus me-2"></i> Tambah Barang
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white border-0 pb-0">
                <form method="GET" action="{{ route('barang.index') }}" class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text"
                                   name="q"
                                   class="form-control border-0 shadow-none"
                                   placeholder="Cari nama / kode barang"
                                   value="{{ request('q') }}">
                        </div>
                    </div>

                    <div class="col-md-3">
                        @php $selectedStatus = request('status'); @endphp
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua status</option>
                            <option value="tersedia" @selected($selectedStatus === 'tersedia')>Tersedia</option>
                            <option value="dipinjam" @selected($selectedStatus === 'dipinjam')>Sedang dipinjam</option>
                            <option value="service"  @selected($selectedStatus === 'service')>Sedang service</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-sm btn-outline-secondary w-100" type="submit">
                            Filter
                        </button>
                    </div>

                    <div class="col-md-3 text-md-end small text-muted mt-2 mt-md-0">
                        Total barang: <span class="fw-semibold">{{ $barang->count() }}</span>
                    </div>
                </form>
            </div>

            <div class="table-responsive mt-3">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th style="width:110px;">Foto</th>
                            <th>Nama & Kategori</th>
                            <th>Kode</th>
                            <th class="text-center">Stok Total</th>
                            <th class="text-center">Dipinjam</th>
                            <th class="text-center">Service</th>
                            <th class="text-center">Tersedia</th>
                            <th class="text-center">Status</th>
                            <th class="text-end" style="width:220px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($barang as $item)
                            <tr>
                                {{-- FOTO --}}
                                <td>
                                    @if($item->foto_url)
                                        <img src="{{ $item->foto_url }}"
                                             alt="Foto {{ $item->nama_barang }}"
                                             class="rounded"
                                             style="width:80px;height:80px;object-fit:cover;">
                                    @else
                                        <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                             style="width:80px;height:80px;">
                                            <i class="fas fa-box text-muted"></i>
                                        </div>
                                    @endif
                                </td>

                                {{-- NAMA & KATEGORI --}}
                                <td class="fw-semibold">
                                    {{ $item->nama_barang }}
                                    <div class="small text-muted">
                                        {{ $item->kategori->nama_kategori ?? '-' }}
                                    </div>
                                </td>

                                {{-- KODE --}}
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $item->kode_barang }}
                                    </span>
                                </td>

                                {{-- STOK TOTAL --}}
                                <td class="text-center">
                                    {{ $item->stok ?? 0 }}
                                </td>

                                {{-- DIPINJAM --}}
                                <td class="text-center">
                                    {{ $item->stok_dipinjam }}
                                </td>

                                {{-- SERVICE --}}
                                <td class="text-center">
                                    {{ $item->stok_service }}
                                </td>

                                {{-- STOK TERSEDIA --}}
                                <td class="text-center fw-semibold">
                                    {{ $item->stok_tersedia }}
                                </td>

                                {{-- STATUS OTOMATIS --}}
                                <td class="text-center">
                                    @php $status = $item->status_otomatis; @endphp

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

                                {{-- AKSI --}}
                                <td class="text-end">
                                    <div class="btn-group btn-group-sm mb-1" role="group">
                                        <a href="{{ route('barang.show', $item->id_barang) }}"
                                           class="btn btn-light border">
                                            <i class="fas fa-eye me-1"></i> Detail
                                        </a>
                                        <a href="{{ route('petugas.barang.edit', $item->id_barang) }}"
                                           class="btn btn-light border">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                        <form action="{{ route('petugas.barang.destroy', $item->id_barang) }}"
                                              method="POST"
                                              class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="btn btn-light border text-danger"
                                                    onclick="return confirm('Hapus barang ini?')">
                                                <i class="fas fa-trash-alt me-1"></i> Hapus
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Manajemen stok cepat (+1 / -1) --}}
                                    <div class="d-flex justify-content-end gap-1">
                                        <form action="{{ route('petugas.barang.stok.kurang', $item->id_barang) }}"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="jumlah" value="1">
                                            <button class="btn btn-outline-secondary btn-sm px-2 py-0"
                                                    type="submit"
                                                    title="Kurangi stok total 1">
                                                −
                                            </button>
                                        </form>
                                        <form action="{{ route('petugas.barang.stok.tambah', $item->id_barang) }}"
                                              method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="jumlah" value="1">
                                            <button class="btn btn-outline-secondary btn-sm px-2 py-0"
                                                    type="submit"
                                                    title="Tambah stok total 1">
                                                +
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    <i class="fas fa-box-open me-2"></i>
                                    Belum ada barang.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer bg-white small text-muted">
                <strong>Keterangan:</strong>
                <span class="ms-2">Stok Total = stok di database,</span>
                <span class="ms-2">Tersedia = stok total − dipinjam − service.</span>
            </div>
        </div>

    @else
        {{-- ====== VIEW MAHASISWA / USER BIASA: KARTU BARANG ====== --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <p class="text-muted small mb-1">
                    Dashboard /
                    <span class="text-dark fw-semibold">Barang</span>
                </p>
                <h1 class="h4 mb-1 fw-bold text-dark">Daftar Barang Tersedia</h1>
                <small class="text-muted">
                    Lihat barang yang dapat Anda pinjam dari kampus
                </small>
            </div>
        </div>

        <div class="row g-3">
            @forelse($barang ?? $barangs ?? [] as $item)
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm">
                        {{-- FOTO --}}
                        @if($item->foto_url)
                            <img src="{{ $item->foto_url }}"
                                 class="card-img-top"
                                 alt="Foto {{ $item->nama_barang }}"
                                 style="height: 180px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                 style="height:180px;">
                                <i class="fas fa-box-open text-muted fs-1"></i>
                            </div>
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-semibold">{{ $item->nama_barang }}</h5>
                            <p class="card-text small text-muted mb-2">
                                {{ \Illuminate\Support\Str::limit($item->deskripsi ?? '-', 100) }}
                            </p>

                            <p class="card-text small mb-3">
                                <span class="d-block text-muted">
                                    Kode: <span class="fw-semibold">{{ $item->kode_barang }}</span>
                                </span>
                                <span class="d-block text-muted">
                                    Stok tersedia:
                                    <span class="fw-semibold">{{ $item->stok_tersedia }}</span>
                                </span>
                                <span class="d-block">
                                    Status:
                                    @php $statusUser = $item->status_otomatis; @endphp

                                    @if($statusUser === 'tersedia')
                                        <span class="badge bg-success">Tersedia</span>
                                    @elseif($statusUser === 'dipinjam')
                                        <span class="badge bg-warning text-dark">Sedang Dipinjam</span>
                                    @elseif($statusUser === 'service')
                                        <span class="badge bg-info text-dark">Sedang Service</span>
                                    @elseif($statusUser === 'habis')
                                        <span class="badge bg-secondary">Stok Habis</span>
                                    @else
                                        <span class="badge bg-danger">{{ ucfirst($statusUser) }}</span>
                                    @endif
                                </span>
                            </p>

                            <div class="mt-auto">
                                <a href="{{ route('barang.show', $item->id_barang ?? $item->id ?? '') }}"
                                   class="btn btn-primary w-100">
                                    Detail Barang
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info border-0 shadow-sm">
                        <i class="fas fa-info-circle me-2"></i>
                        Tidak ada barang tersedia saat ini.
                    </div>
                </div>
            @endforelse
        </div>
    @endif

</div>
@endsection
