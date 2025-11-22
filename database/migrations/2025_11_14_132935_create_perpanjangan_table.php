<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('perpanjangan', function (Blueprint $table) {
            $table->increments('id_perpanjangan');
            $table->unsignedInteger('id_peminjaman')->index();
            $table->text('alasan');
            $table->dateTime('waktu_perpanjangan');
            $table->dateTime('waktu_pengajuan');
            $table->enum('status_persetujuan', ['ditolak', 'disetujui', 'menunggu'])->default('menunggu');

            $table->foreign('id_peminjaman')
                ->references('id_peminjaman')
                ->on('peminjaman')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('perpanjangan');
    }
};
