<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\PengembalianController;
use App\Http\Controllers\KeluhanController;
use App\Http\Controllers\PerpanjanganController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\QrController;
use App\Http\Controllers\RiwayatController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PetugasController;

Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'petugas'   => redirect()->route('petugas.dashboard'),
            'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
            default     => redirect()->route('login'),
        };
    }

    return redirect()->route('login');
})->name('home');

Route::get('/dashboard', function () {
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('home');
    }

    return match ($user->role) {
        'petugas'   => redirect()->route('petugas.dashboard'),
        'mahasiswa' => redirect()->route('mahasiswa.dashboard'),
        default     => redirect()->route('home'),
    };
})->middleware('auth')->name('dashboard');


// | Mahasiswa

Route::middleware(['auth', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'index'])->name('dashboard');

        Route::resource('peminjaman', PeminjamanController::class);
        Route::resource('keluhan', KeluhanController::class)->except(['edit', 'update', 'destroy']);
        Route::resource('perpanjangan', PerpanjanganController::class);
        Route::resource('notifikasi', NotifikasiController::class)->only(['index']);
        Route::get('/qr/{id}', [QrController::class, 'show'])->name('qr.show');
        Route::get('/riwayat', [RiwayatController::class, 'index'])->name('riwayat.index');
        Route::get('/riwayat/{riwayat}', [RiwayatController::class, 'show'])->name('riwayat.show');

        // Pengembalian oleh mahasiswa (create & store)
        Route::resource('pengembalian', PengembalianController::class)->only(['create', 'store']);
    });


// | Petugas

Route::middleware(['auth', 'role:petugas'])
    ->prefix('petugas')
    ->name('petugas.')
    ->group(function () {
        Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('dashboard');

        // Resource barang untuk petugas (tanpa index & show)
        Route::resource('barang', BarangController::class)->except(['index', 'show']);

        // Manajemen stok cepat untuk petugas
        Route::patch('barang/{barang}/stok/tambah', [BarangController::class, 'stokTambah'])
            ->name('barang.stok.tambah');
        Route::patch('barang/{barang}/stok/kurang', [BarangController::class, 'stokKurang'])
            ->name('barang.stok.kurang');

        Route::resource('kategori', KategoriController::class);

        // Modul service (petugas.service.*)
        Route::resource('service', ServiceController::class)->only(['index', 'update']);

        // Denda (sesuai punyamu sekarang)
        Route::resource('denda', DendaController::class)->except(['create', 'store']);

        // Route tambahan untuk proses pengembalian via QR
        Route::get('pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
        Route::get('pengembalian/scan', [PengembalianController::class, 'scanForm'])->name('pengembalian.scan');
        Route::post('pengembalian/scan', [PengembalianController::class, 'handleScan'])->name('pengembalian.handleScan');
<<<<<<< Updated upstream
        Route::post('pengembalian/{peminjaman}/proses', [PengembalianController::class, 'prosesLengkap'])->name('pengembalian.prosesLengkap');
=======
>>>>>>> Stashed changes
        Route::get('pengembalian/{peminjaman}/konfirmasi', [PengembalianController::class, 'konfirmasi'])->name('pengembalian.konfirmasi');
        Route::post('pengembalian/{peminjaman}/tanpa-kerusakan', [PengembalianController::class, 'prosesTanpaKerusakan'])->name('pengembalian.tanpaKerusakan');
        Route::get('pengembalian/{peminjaman}/kerusakan', [PengembalianController::class, 'formKerusakan'])->name('pengembalian.formKerusakan');
        Route::post('pengembalian/{peminjaman}/kerusakan', [PengembalianController::class, 'prosesDenganKerusakan'])->name('pengembalian.prosesKerusakan');

        Route::get('booking', [PeminjamanController::class, 'booking'])->name('booking.index');
        Route::resource('peminjaman', PeminjamanController::class)->only(['index', 'show', 'destroy']);
        Route::resource('keluhan', KeluhanController::class)->only(['index', 'show']);
        Route::post('keluhan/{keluhan}/service', [KeluhanController::class, 'kirimService'])->name('keluhan.service');
        Route::post('keluhan/{keluhan}/selesai', [KeluhanController::class, 'tandaiSelesai'])->name('keluhan.selesai');
        Route::resource('notifikasi', NotifikasiController::class)->only(['index']);
        Route::get('riwayat-transaksi', [\App\Http\Controllers\RiwayatController::class, 'petugas'])->name('riwayat.index');
        Route::get('riwayat-transaksi/export/csv', [\App\Http\Controllers\RiwayatController::class, 'exportCsv'])->name('riwayat.export.csv');
        Route::get('riwayat-transaksi/export/html', [\App\Http\Controllers\RiwayatController::class, 'exportHtml'])->name('riwayat.export.html');
    });


// | Barang (read-only untuk semua user login)

Route::middleware(['auth'])->group(function () {
    Route::get('/barang', [BarangController::class, 'index'])->name('barang.index');
    Route::get('/barang/{barang}', [BarangController::class, 'show'])->name('barang.show');

    // Profil custom (tidak bentrok dengan route bawaan profile.edit/update)
    Route::view('/profil', 'profile.show')->name('profile.show');
});

require __DIR__.'/auth.php';
