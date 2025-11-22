<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Barang extends Model
{
    protected $table = 'barang';

    protected $primaryKey = 'id_barang';

    public $timestamps = false;

    protected $fillable = [
        'id_kategori',
        'nama_barang',
        'status',
        'kode_barang',
        'harga',
        'stok',        
        'foto_path',
        'deskripsi',   
    ];


    protected $appends = [
        'foto_url',
        'stok_tersedia',
        'stok_dipinjam',
        'stok_service',
        'status_otomatis',
    ];

    // ====== RELASI ======

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'id_barang', 'id_barang');
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'id_barang', 'id_barang');
    }

    public function service(): HasMany
    {
        return $this->hasMany(Service::class, 'id_barang', 'id_barang');
    }

    // ====== ACCESSOR FOTO ======

    public function getFotoUrlAttribute(): ?string
    {
        return $this->foto_path
            ? asset('storage/' . ltrim($this->foto_path, '/'))
            : null;
    }

    // ====== ACCESSOR STOK BERDASARKAN TRANSAKSI ======

    
    // Banyak unit yang sedang dipinjam (status peminjaman = 'dipinjam').
    public function getStokDipinjamAttribute(): int
    {
        return (int) $this->peminjaman()
            ->where('status', 'dipinjam')             
            ->count();                       
    }

     // Banyak unit yang sedang dalam service (status service = 'service').
    public function getStokServiceAttribute(): int
    {
        return (int) $this->service()
            ->where('status', 'service')                    
            ->count();
    }

    
    // Stok yang masih benar-benar tersedia sekarang.
    public function getStokTersediaAttribute(): int
    {
        $total    = (int) ($this->stok ?? 0);
        $dipinjam = $this->stok_dipinjam;
        $service  = $this->stok_service;

        $tersedia = $total - $dipinjam - $service;

        return $tersedia > 0 ? $tersedia : 0;
    }

    
     // Status otomatis berdasarkan stok & transaksi.
     // Override dengan status khusus (rusak/hilang/nonaktif).
     
    public function getStatusOtomatisAttribute(): string
    {
        // Status khusus yang tidak mau dioverride oleh sistem
        if (in_array($this->status, ['rusak', 'hilang', 'nonaktif'], true)) {
            return $this->status;
        }

        if ($this->stok_tersedia > 0) {
            return 'tersedia';
        }

        if ($this->stok_service > 0) {
            return 'service';
        }

        if ($this->stok_dipinjam > 0) {
            return 'dipinjam';
        }

        // stok total 0 dan tidak ada aktivitas → habis
        return 'habis';
    }
}
