@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Daftar Peminjaman</h1>
        <small class="text-muted">Pantau semua permintaan peminjaman Anda</small>
    </div>
    <a href="{{ route('mahasiswa.peminjaman.create') }}" class="btn btn-primary">Tambah Peminjaman</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th>Kode</th>
                    <th>Barang</th>
                    <th>Periode</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($peminjaman as $item)
                    <tr>
                        <td>{{ $item->id_peminjaman }}</td>
                        <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                        <td>
                            {{ \Carbon\Carbon::parse($item->waktu_awal)->format('d M Y H:i') }}<br>
                            <small class="text-muted">s/d {{ \Carbon\Carbon::parse($item->waktu_akhir)->format('d M Y H:i') }}</small>
                        </td>
                        <td>
                            <span class="badge bg-{{ $item->status === 'berlangsung' ? 'info' : ($item->status === 'selesai' ? 'success' : 'secondary') }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('mahasiswa.peminjaman.show', $item->id_peminjaman) }}" class="btn btn-sm btn-outline-primary">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Belum ada data peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
