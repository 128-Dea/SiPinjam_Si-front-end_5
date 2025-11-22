@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color:#F3F4F6;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-muted small mb-1">
                Dashboard /
                <span class="text-dark fw-semibold">Service Barang</span>
            </p>
            <h1 class="h4 mb-0 fw-bold">Daftar Service Barang</h1>
            <small class="text-muted">
                List barang yang sedang / pernah dalam perbaikan, lengkap dengan rincian kerusakan.
            </small>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:60px;">ID</th>
                        <th>Barang & Peminjam</th>
                        <th>Rincian Kerusakan</th>
                        <th style="width:160px;">Tgl Masuk Service</th>
                        <th style="width:170px;">Estimasi Selesai</th>
                        <th style="width:130px;">Status</th>
                        <th style="width:260px;">Update</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($service as $item)
                        @php
                            $barang   = optional(optional(optional($item->keluhan)->peminjaman)->barang);
                            $pengguna = optional(optional(optional($item->keluhan)->peminjaman)->pengguna);
                        @endphp

                        <tr>
                            {{-- ID SERVICE --}}
                            <td>#{{ $item->id_service }}</td>

                            {{-- BARANG & PEMINJAM --}}
                            <td>
                                <div class="fw-semibold">
                                    {{ $barang->nama_barang ?? '-' }}
                                </div>
                                <div class="small text-muted">
                                    Peminjam: {{ $pengguna->nama ?? '-' }}
                                </div>
                            </td>

                            {{-- RINCIAN KERUSAKAN --}}
                            <td class="small">
                                {{ \Illuminate\Support\Str::limit($item->keluhan->keluhan ?? '-', 120) }}
                            </td>

                            {{-- TANGGAL MASUK SERVICE --}}
                            <td>
                                <form method="POST"
                                      action="{{ route('petugas.service.update', $item->id_service) }}"
                                      class="d-flex flex-column gap-1">
                                    @csrf
                                    @method('PUT')

                                    <input type="date"
                                           name="tgl_masuk_service"
                                           class="form-control form-control-sm"
                                           value="{{ $item->tgl_masuk_service ? $item->tgl_masuk_service->format('Y-m-d') : '' }}">
                            </td>

                            {{-- ESTIMASI SELESAI --}}
                            <td>
                                    <input type="date"
                                           name="estimasi_selesai"
                                           class="form-control form-control-sm"
                                           value="{{ $item->estimasi_selesai ? $item->estimasi_selesai->format('Y-m-d') : '' }}">
                            </td>

                            {{-- STATUS --}}
                            <td>
                                {{-- Badge status saat ini --}}
                                <div class="mb-1">
                                    @if($item->status === 'selesai')
                                        <span class="badge bg-success">Selesai</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Proses</span>
                                    @endif
                                </div>

                                {{-- Dropdown untuk ubah status --}}
                                <select name="status"
                                        class="form-select form-select-sm">
                                    <option value="proses"  @selected($item->status === 'proses')>Proses</option>
                                    <option value="selesai" @selected($item->status === 'selesai')>Selesai</option>
                                </select>
                            </td>

                            {{-- AKSI UPDATE --}}
                            <td>
                                    <button type="submit"
                                            class="btn btn-sm btn-primary w-100 mb-1">
                                        Simpan Perubahan
                                    </button>

                                    @if($item->status !== 'selesai')
                                        <button type="submit"
                                                name="status"
                                                value="selesai"
                                                class="btn btn-sm btn-outline-success w-100"
                                                onclick="return confirm('Tandai service ini selesai dan kembalikan barang ke stok?')">
                                            Tandai Selesai & Kembalikan Stok
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada data service.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
