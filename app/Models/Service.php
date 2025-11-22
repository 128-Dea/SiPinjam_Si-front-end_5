<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Service extends Model
{
    protected $table = 'service';

    protected $primaryKey = 'id_service';

    public $timestamps = false;

    protected $fillable = [
        'id_keluhan',
        'status',              // proses / selesai
        'tgl_masuk_service',   // tanggal barang masuk service
        'estimasi_selesai',    // estimasi selesai service
    ];

    protected $casts = [
        'tgl_masuk_service' => 'datetime',
        'estimasi_selesai'  => 'datetime',
    ];

    public function keluhan(): BelongsTo
    {
        return $this->belongsTo(Keluhan::class, 'id_keluhan', 'id_keluhan');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
