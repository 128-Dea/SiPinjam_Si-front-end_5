<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengguna extends Model
{
    protected $table = 'pengguna';

    protected $primaryKey = 'id_pengguna';

    public $timestamps = false;

    protected $fillable = [
        'nama',
        'email',
        'nomor_hp',
        'role',
    ];

    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'id_pengguna', 'id_pengguna');
    }

    public function keluhan(): HasMany
    {
        return $this->hasMany(Keluhan::class, 'id_pengguna', 'id_pengguna');
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class, 'id_pengguna', 'id_pengguna');
    }

    public function serahTerimaSebagaiPenggunaLama(): HasMany
    {
        return $this->hasMany(SerahTerima::class, 'pengguna_lama', 'id_pengguna');
    }

    public function serahTerimaSebagaiPenggunaBaru(): HasMany
    {
        return $this->hasMany(SerahTerima::class, 'pengguna_baru', 'id_pengguna');
    }
}