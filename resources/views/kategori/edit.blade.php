@extends('layouts.app')

@section('content')
<h1 class="h3 mb-4">Edit Kategori</h1>
<form method="POST" action="{{ route('petugas.kategori.update', $kategori->id_kategori) }}" class="card border-0 shadow-sm">
    @csrf
    @method('PUT')
    <div class="card-body">
        <div class="mb-3">
            <label class="form-label">Nama Kategori</label>
            <input type="text" name="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" class="form-control" required>
        </div>
    </div>
    <div class="card-footer text-end bg-white">
        <a href="{{ route('petugas.kategori.index') }}" class="btn btn-light">Batal</a>
        <button class="btn btn-primary" type="submit">Perbarui</button>
    </div>
</form>
@endsection
