@extends('layouts.app')

@section('content')
<h1 class="h3 mb-4">Riwayat Peminjaman</h1>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead>
                <tr>
                    <th>Nama Mahasiswa</th>
                    <th>Barang</th>
                    <th>Tanggal Pinjam</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Total Denda</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $item)
                    @php
                        $peminjaman = $item->pengembalian->peminjaman ?? null;
                        $denda = $peminjaman?->denda?->sum('total_denda') ?? 0;
                    @endphp
                    <tr>
                        <td>{{ $peminjaman->pengguna->nama ?? '-' }}</td>
                        <td>{{ $peminjaman->barang->nama_barang ?? '-' }}</td>
                        <td>{{ optional($peminjaman?->waktu_awal ? \Carbon\Carbon::parse($peminjaman->waktu_awal) : null)->format('d M Y') }}</td>
                        <td>{{ optional($item->pengembalian?->waktu_pengembalian)->format('d M Y') ?? '-' }}</td>
                        <td>
                            @if($denda > 0)
                                <span class="badge bg-danger">Rp {{ number_format($denda, 0, ',', '.') }}</span>
                            @else
                                <span class="badge bg-success">Tidak ada</span>
                            @endif
                        </td>
                        <td><a href="{{ route('mahasiswa.riwayat.show', $item->id_riwayat) }}" class="btn btn-sm btn-outline-primary">Detail</a></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Riwayat masih kosong.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
