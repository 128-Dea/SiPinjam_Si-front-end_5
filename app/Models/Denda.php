<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Denda extends Model
{
    protected $table = 'denda';

    protected $primaryKey = 'id_denda';

    public $timestamps = false;

    protected $fillable = [
        'id_peminjaman',
        'jenis',               // terlambat / rusak / hilang
        'total_denda',
        'status_pembayaran',  
        'keterangan',
        'metode_pembayaran',   // cash / transfer 
        'bukti_transfer_path', 
    ];

    protected $appends = [
        'bukti_transfer_url',
    ];

    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    public function getBuktiTransferUrlAttribute(): ?string
    {
        return $this->bukti_transfer_path
            ? asset('storage/' . ltrim($this->bukti_transfer_path, '/'))
            : null;
    }
}
