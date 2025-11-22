<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('keluhan', function (Blueprint $table) {
            $table->increments('id_keluhan');
            $table->text('keluhan');
            $table->unsignedInteger('id_pengguna');
            $table->unsignedInteger('id_peminjaman');

            $table->foreign('id_pengguna')
                ->references('id_pengguna')
                ->on('pengguna')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('id_peminjaman')
                ->references('id_peminjaman')
                ->on('peminjaman')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('keluhan');
    }
};
