@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color:#F3F4F6;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0 fw-bold">Tambah Denda</h1>
        <a href="{{ route('petugas.denda.index') }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    <form method="POST"
          action="{{ route('petugas.denda.store') }}"
          class="card border-0 shadow-sm rounded-4">
        @csrf

        <div class="card-body p-4">
            {{-- PEMINJAMAN --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Peminjaman</label>
                <select name="id_peminjaman"
                        class="form-select @error('id_peminjaman') is-invalid @enderror"
                        required>
                    <option value="">-- Pilih peminjam --</option>
                    @foreach($peminjaman as $item)
                        <option value="{{ $item->id_peminjaman }}"
                            @selected(old('id_peminjaman') == $item->id_peminjaman)>
                            {{ $item->pengguna->nama ?? 'Pengguna' }}
                            -
                            {{ $item->barang->nama_barang ?? 'Barang' }}
                        </option>
                    @endforeach
                </select>
                @error('id_peminjaman')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>

            {{-- JENIS DENDA --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Jenis Denda</label>
                <select name="jenis"
                        class="form-select @error('jenis') is-invalid @enderror"
                        required>
                    <option value="">-- Pilih jenis denda --</option>
                    <option value="terlambat" @selected(old('jenis')=='terlambat')>Terlambat</option>
                    <option value="rusak" @selected(old('jenis')=='rusak')>Rusak</option>
                    <option value="hilang" @selected(old('jenis')=='hilang')>Hilang</option>
                </select>
                @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted d-block mt-1">
                    - <strong>Terlambat</strong>: denda = menit terlambat × Rp 1.000<br>
                    - <strong>Hilang</strong>: denda = harga barang<br>
                    - <strong>Rusak</strong>: nominal bisa diisi manual (sudah diatur di pengembalian)
                </small>
            </div>

            {{-- MENIT TERLAMBAT (opsional, untuk jenis terlambat) --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">
                    Lama Keterlambatan (menit)
                    <span class="text-muted fw-normal">(opsional, isi jika jenis terlambat)</span>
                </label>
                <input type="number"
                       name="menit_terlambat"
                       value="{{ old('menit_terlambat') }}"
                       class="form-control @error('menit_terlambat') is-invalid @enderror"
                       min="0">
                @error('menit_terlambat')<div class="invalid-feedback">{{ $message }}</div>@enderror>
            </div>

            {{-- TOTAL DENDA (untuk jenis rusak / override) --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Total Denda (Rp)</label>
                <input type="number"
                       name="total_denda"
                       value="{{ old('total_denda') }}"
                       class="form-control @error('total_denda') is-invalid @enderror"
                       min="0">
                @error('total_denda')<div class="invalid-feedback">{{ $message }}</div>@enderror
                <small class="text-muted d-block mt-1">
                    - Untuk <strong>hilang</strong> & <strong>terlambat</strong>, nominal akan dihitung otomatis.<br>
                    - Untuk <strong>rusak</strong>, isi nominal denda di sini.
                </small>
            </div>

            {{-- KETERANGAN --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Keterangan</label>
                <textarea name="keterangan"
                          rows="3"
                          class="form-control @error('keterangan') is-invalid @enderror"
                          placeholder="Opsional, keterangan tambahan">{{ old('keterangan') }}</textarea>
                @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
        </div>

        <div class="card-footer bg-white text-end">
            <button type="submit" class="btn btn-primary">
                Simpan Denda
            </button>
        </div>
    </form>
</div>
@endsection
