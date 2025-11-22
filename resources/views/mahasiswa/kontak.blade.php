@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-1">Kontak Petugas</h1>
        <small class="text-muted">Hubungi petugas jika membutuhkan bantuan.</small>
    </div>
</div>

<div class="row g-3">
    @php
        $contacts = [
            ['nama' => 'Call Center SIPKAM', 'nomor' => '0812-3456-7890', 'ikon' => 'fa-headset', 'warna' => 'primary'],
            ['nama' => 'Email', 'nomor' => 'SIPKAM@admin.ac.id', 'ikon' => 'fa-user-tie', 'warna' => 'success'],
        ];
    @endphp

    @foreach($contacts as $item)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-{{ $item['warna'] }} bg-opacity-10 text-{{ $item['warna'] }} d-flex align-items-center justify-content-center" style="width:52px;height:52px;">
                        <i class="fas {{ $item['ikon'] }}"></i>
                    </div>
                    <div>
                        <div class="fw-semibold">{{ $item['nama'] }}</div>
                        <div class="text-muted">{{ $item['nomor'] }}</div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
