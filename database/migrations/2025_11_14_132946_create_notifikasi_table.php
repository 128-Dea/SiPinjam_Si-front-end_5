<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->increments('id_notifikasi');
            $table->unsignedInteger('id_barang');
            $table->unsignedInteger('id_pengguna');
            $table->text('pesan');
            $table->enum('jenis', ['perpanjangan', 'denda', 'serah_terima']);

            $table->foreign('id_barang')
                ->references('id_barang')
                ->on('barang')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('pengguna')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
