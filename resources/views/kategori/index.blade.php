@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between mb-4">
    <h1 class="h3 mb-0">Kategori Barang</h1>
    <a href="{{ route('petugas.kategori.create') }}" class="btn btn-primary">Tambah Kategori</a>
</div>

<div class="card border-0 shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped mb-0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategori as $item)
                    <tr>
                        <td>{{ $item->id_kategori }}</td>
                        <td>{{ $item->nama_kategori }}</td>
                        <td class="text-end">
                            <a href="{{ route('petugas.kategori.edit', $item->id_kategori) }}" class="btn btn-sm btn-outline-primary me-1">Edit</a>
                            <form action="{{ route('petugas.kategori.destroy', $item->id_kategori) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Hapus kategori ini?')">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
