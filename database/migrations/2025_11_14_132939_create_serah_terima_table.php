<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('serah_terima', function (Blueprint $table) {
            $table->increments('id_serah_terima');
            $table->unsignedInteger('id_peminjaman');
            $table->unsignedInteger('pengguna_lama');
            $table->unsignedInteger('pengguna_baru');
            $table->dateTime('waktu')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('catatan');

            $table->foreign('id_peminjaman')
                ->references('id_peminjaman')
                ->on('peminjaman')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('pengguna_lama')
                ->references('id_pengguna')
                ->on('pengguna')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('pengguna_baru')
                ->references('id_pengguna')
                ->on('pengguna')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('serah_terima');
    }
};
