@extends('layouts.app')

@section('content')
<h1 class="h3 mb-4">Tambah Kategori</h1>
<form method="POST" action="{{ route('petugas.kategori.store') }}" class="card border-0 shadow-sm">
    @csrf
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori') }}" class="form-control" required>
            @error('nama_kategori')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>
    <div class="card-footer text-end bg-white">
        <a href="{{ route('petugas.kategori.index') }}" class="btn btn-light">Batal</a>
        <button class="btn btn-primary" type="submit">Simpan</button>
    </div>
</form>
@endsection
