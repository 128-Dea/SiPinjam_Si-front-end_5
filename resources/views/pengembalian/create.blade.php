@extends('layouts.app')

@section('content')
<h1 class="h3 mb-4">Form Pengembalian</h1>

<form method="POST" action="{{ route('mahasiswa.pengembalian.store') }}" class="card border-0 shadow-sm">
    @csrf
    <div class="card-body">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mb-3">
            <label class="form-label">Peminjaman</label>
            <select name="id_peminjaman" class="form-select" required>
                <option value="">-- Pilih peminjaman yang ingin dikembalikan --</option>
                @foreach($peminjaman as $item)
                    <option value="{{ $item->id_peminjaman }}"
                        {{ old('id_peminjaman') == $item->id_peminjaman ? 'selected' : '' }}>
                        {{ $item->barang->nama_barang ?? 'Barang' }}
                        @if(!empty($item->pengguna?->nama))
                            - {{ $item->pengguna->nama }}
                        @endif
                        (Jatuh tempo: {{ \Carbon\Carbon::parse($item->waktu_akhir)->format('d M Y H:i') }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Tanggal & Jam Pengembalian</label>
            <input
                type="datetime-local"
                name="waktu_pengembalian"
                value="{{ old('waktu_pengembalian', now()->format('Y-m-d\TH:i')) }}"
                class="form-control"
                required
            >
        </div>

        <div class="mb-3">
            <label class="form-label">Catatan (opsional)</label>
            <textarea name="catatan" rows="3" class="form-control">{{ old('catatan') }}</textarea>
        </div>
    </div>

    <div class="card-footer text-end bg-white">
        <a href="{{ route('mahasiswa.riwayat.index') }}" class="btn btn-light">Batal</a>
        <button class="btn btn-primary" type="submit">Kirim Pengembalian</button>
    </div>
</form>
@endsection
