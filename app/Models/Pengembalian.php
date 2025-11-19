<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pengembalian extends Model
{
    protected $table = 'pengembalian';

    protected $primaryKey = 'id_pengembalian';

    public $timestamps = false;

    protected $fillable = [
        'id_peminjaman',
        'waktu_pengembalian',
        'catatan',
    ];

    protected $casts = [
        'waktu_pengembalian' => 'datetime',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function riwayat(): HasOne
    {
        return $this->hasOne(Riwayat::class, 'id_pengembalian', 'id_pengembalian');
    }
}
