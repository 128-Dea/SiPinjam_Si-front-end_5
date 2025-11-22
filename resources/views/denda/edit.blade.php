@extends('layouts.app')

@section('content')
<div class="container-fluid py-4" style="background-color:#F3F4F6;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <p class="text-muted small mb-1">
                <a href="{{ route('petugas.denda.index') }}" class="text-decoration-none text-muted">
                    Denda
                </a>
                /
                <span class="text-dark fw-semibold">Detail Denda #{{ $denda->id_denda }}</span>
            </p>
            <h1 class="h4 mb-0 fw-bold">Detail & Pembayaran Denda</h1>
        </div>
        <a href="{{ route('petugas.denda.index') }}" class="btn btn-outline-secondary">
            Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="row g-3">
        {{-- DETAIL DENDA --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h5 class="card-title mb-3">Informasi Denda</h5>

                    <table class="table table-sm mb-0">
                        <tr>
                            <th style="width:160px;">ID Denda</th>
                            <td>#{{ $denda->id_denda }}</td>
                        </tr>
                        <tr>
                            <th>Nama Peminjam</th>
                            <td>{{ $denda->peminjaman->pengguna->nama ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Barang</th>
                            <td>{{ $denda->peminjaman->barang->nama_barang ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Jenis Denda</th>
                            <td>
                                @if($denda->jenis === 'terlambat')
                                    <span class="badge bg-warning text-dark">Terlambat</span>
                                @elseif($denda->jenis === 'rusak')
                                    <span class="badge bg-danger">Rusak</span>
                                @elseif($denda->jenis === 'hilang')
                                    <span class="badge bg-dark">Hilang</span>
                                @else
                                    <span class="badge bg-secondary">{{ ucfirst($denda->jenis) }}</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Nominal Denda</th>
                            <td>
                                <strong>Rp {{ number_format($denda->total_denda ?? 0, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <th>Detail Nominal</th>
                            <td class="small">
                                @php
                                    $total = $denda->total_denda ?? 0;
                                @endphp

                                @if($denda->jenis === 'terlambat')
                                    @php
                                        $menit = (int) round($total / 1000);
                                    @endphp
                                    Terlambat {{ $menit }} menit × Rp 1.000
                                @elseif($denda->jenis === 'hilang')
                                    @php
                                        $hargaBarang = optional($denda->peminjaman->barang)->harga;
                                    @endphp
                                    Harga barang:
                                    @if($hargaBarang)
                                        Rp {{ number_format($hargaBarang, 0, ',', '.') }}
                                    @else
                                        (harga barang belum diisi)
                                    @endif
                                @else
                                    {{ $denda->keterangan ?? '-' }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Keterangan</th>
                            <td>{{ $denda->keterangan ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status Pembayaran</th>
                            <td>
                                @if($denda->status_pembayaran === 'sudah')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-danger">Belum Lunas</span>
                                @endif
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            @if($denda->bukti_transfer_url)
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Bukti Transfer Saat Ini</h5>
                        <div class="small mb-2">
                            <a href="{{ $denda->bukti_transfer_url }}"
                               target="_blank"
                               class="text-decoration-none">
                                Lihat bukti transfer
                            </a>
                        </div>
                        {{-- Kalau gambar, tampilkan preview kecil --}}
                        @if(Str::endsWith(strtolower($denda->bukti_transfer_path), ['.jpg', '.jpeg', '.png']))
                            <img src="{{ $denda->bukti_transfer_url }}"
                                 alt="Bukti Transfer"
                                 class="img-fluid rounded border"
                                 style="max-height: 240px; object-fit: contain;">
                        @endif
                    </div>
                </div>
            @endif
        </div>

        {{-- FORM PEMBAYARAN --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm">
                <form method="POST"
                      action="{{ route('petugas.denda.update', $denda->id_denda) }}"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <h5 class="card-title mb-3">Proses Pembayaran</h5>

                        {{-- METODE PEMBAYARAN --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Metode Pembayaran</label>
                            <select name="metode_pembayaran"
                                    class="form-select @error('metode_pembayaran') is-invalid @enderror"
                                    required>
                                <option value="">-- Pilih metode --</option>
                                <option value="cash" @selected($denda->metode_pembayaran === 'cash')>Cash</option>
                                <option value="transfer" @selected($denda->metode_pembayaran === 'transfer')>Transfer</option>
                            </select>
                            @error('metode_pembayaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted d-block mt-1">
                                Jika <strong>cash</strong>, tidak perlu upload bukti. Jika <strong>transfer</strong>,
                                wajib upload bukti pembayaran di bawah.
                            </small>
                        </div>

                        {{-- BUKTI TRANSFER (wajib jika transfer) --}}
                        <div class="mb-3" id="bukti-transfer-container" style="display: none;">
                            <label class="form-label fw-semibold">Upload Bukti Transfer <span class="text-danger">*</span></label>
                            <input type="file"
                                   name="bukti_transfer"
                                   class="form-control @error('bukti_transfer') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png,.pdf">
                            @error('bukti_transfer')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted d-block mt-1">
                                Format: JPG, PNG, atau PDF maksimal 2MB. Wajib diisi jika memilih transfer.
                            </small>
                        </div>

                        {{-- STATUS PEMBAYARAN --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Status Pembayaran</label>
                            <select name="status_pembayaran"
                                    class="form-select @error('status_pembayaran') is-invalid @enderror"
                                    required>
                                <option value="belum" @selected($denda->status_pembayaran === 'belum')>Belum Lunas</option>
                                <option value="sudah" @selected($denda->status_pembayaran === 'sudah')>Sudah Lunas</option>
                            </select>
                            @error('status_pembayaran')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <small class="text-muted d-block mt-1">
                                Pilih <strong>Sudah Lunas</strong> setelah pembayaran diterima
                                (cash atau transfer).
                            </small>
                        </div>
                    </div>

                    <div class="card-footer bg-white text-end">
                        <button type="submit" class="btn btn-primary">
                            Simpan & Verifikasi
                        </button>
                    </div>
                </form>
            </div>

            {{-- Tombol cepat: Verifikasi lunas (cash) --}}
            @if($denda->status_pembayaran === 'belum')
                <div class="card border-0 shadow-sm mt-3">
                    <div class="card-body">
                        <h6 class="fw-semibold mb-2">Verifikasi Cepat (Cash)</h6>
                        <p class="small text-muted mb-3">
                            Jika pengguna membayar <strong>tunai</strong> dan tidak membutuhkan bukti transfer,
                            gunakan tombol ini untuk langsung menandai sebagai lunas.
                        </p>
                        <form method="POST"
                              action="{{ route('petugas.denda.update', $denda->id_denda) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status_pembayaran" value="sudah">
                            <input type="hidden" name="metode_pembayaran" value="cash">
                            <button type="submit"
                                    class="btn btn-success"
                                    onclick="return confirm('Tandai denda ini sebagai lunas (cash)?')">
                                Verifikasi Lunas (Cash)
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const metodeSelect = document.querySelector('select[name="metode_pembayaran"]');
    const buktiContainer = document.getElementById('bukti-transfer-container');
    const buktiInput = document.querySelector('input[name="bukti_transfer"]');

    function toggleBuktiTransfer() {
        if (metodeSelect.value === 'transfer') {
            buktiContainer.style.display = 'block';
            buktiInput.setAttribute('required', 'required');
        } else {
            buktiContainer.style.display = 'none';
            buktiInput.removeAttribute('required');
        }
    }

    metodeSelect.addEventListener('change', toggleBuktiTransfer);
    toggleBuktiTransfer(); // Initial check
});
</script>
@endsection
