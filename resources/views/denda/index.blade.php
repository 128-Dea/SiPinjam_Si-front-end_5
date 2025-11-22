@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color:#F3F4F6;">

    <div class="d-flex justify-content-between mb-4">
        <div>
            <p class="text-muted small mb-1">
                Dashboard / <span class="text-dark fw-semibold">Denda Peminjaman</span>
            </p>
            <h1 class="h4 mb-0 fw-bold">Denda Peminjaman</h1>
            <small class="text-muted">
                Daftar pengguna yang terkena denda (terlambat, rusak, hilang)
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
                        <th>Pengguna & Barang</th>
                        <th>Jenis</th>
                        <th>Nominal</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Bukti Transfer</th>
                        <th style="width:180px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($denda as $item)
                        @php
                            $jenis = $item->jenis;
                            $total = $item->total_denda ?? 0;
                        @endphp
                        <tr>
                            <td>{{ $item->id_denda }}</td>

                            {{-- PENGGUNA & BARANG --}}
                            <td>
                                <div class="fw-semibold">
                                    {{ $item->peminjaman->pengguna->nama ?? '-' }}
                                </div>
                                <div class="small text-muted">
                                    {{ $item->peminjaman->barang->nama_barang ?? '-' }}
                                </div>
                            </td>

                            {{-- JENIS --}}
                            <td>
                                @if($jenis === 'terlambat')
                                    <span class="badge bg-warning text-dark">Terlambat</span>
                                @elseif($jenis === 'rusak')
                                    <span class="badge bg-danger">Rusak</span>
                                @elseif($jenis === 'hilang')
                                    <span class="badge bg-dark">Hilang</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($jenis) }}</span>
                                @endif
                            </td>

                            {{-- NOMINAL --}}
                            <td>
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </td>

                            {{-- DETAIL NOMINAL --}}
                            <td class="small">
                                @if($jenis === 'terlambat')
                                    @php
                                        $menit = (int) round($total / 1000);
                                    @endphp
                                    Terlambat {{ $menit }} menit × Rp 1.000
                                @elseif($jenis === 'hilang')
                                    @php
                                        $hargaBarang = optional($item->peminjaman->barang)->harga;
                                    @endphp
                                    Harga barang:
                                    @if($hargaBarang)
                                        Rp {{ number_format($hargaBarang, 0, ',', '.') }}
                                    @else
                                        (harga barang belum diisi)
                                    @endif
                                @else
                                    {{ $item->keterangan ?? '-' }}
                                @endif
                            </td>

                            {{-- METODE --}}
                            <td>
                                @if($item->metode_pembayaran === 'cash')
                                    <span class="badge bg-success">Cash</span>
                                @elseif($item->metode_pembayaran === 'transfer')
                                    <span class="badge bg-primary">Transfer</span>
                                @else
                                    <span class="badge bg-secondary">Belum dipilih</span>
                                @endif
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @if($item->status_pembayaran === 'sudah')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-danger">Belum Lunas</span>
                                @endif
                            </td>

                            {{-- BUKTI TRANSFER --}}
                            <td class="small">
                                @if($item->bukti_transfer_url)
                                    <a href="{{ $item->bukti_transfer_url }}"
                                       target="_blank"
                                       class="text-decoration-none">
                                        Lihat bukti
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            {{-- AKSI --}}
                            <td>
                                <div class="d-flex flex-column gap-1">
                                    <a href="{{ route('petugas.denda.edit', $item->id_denda) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        Detail & Pembayaran
                                    </a>

                                    @if($item->status_pembayaran === 'belum')
                                        {{-- Tombol cepat: verifikasi lunas (cash) --}}
                                        <form method="POST"
                                              action="{{ route('petugas.denda.update', $item->id_denda) }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status_pembayaran" value="sudah">
                                            <input type="hidden" name="metode_pembayaran" value="cash">
                                            <button class="btn btn-sm btn-success w-100"
                                                    onclick="return confirm('Tandai denda ini sebagai lunas (cash)?')">
                                                Verifikasi Lunas (Cash)
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Tidak ada denda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
