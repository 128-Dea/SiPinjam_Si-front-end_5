<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('qr', function (Blueprint $table) {
            $table->increments('id_qr');
            $table->string('qr_code', 255)->unique();
            $table->enum('jenis_transaksi', ['peminjaman', 'serah_terima']);
            $table->unsignedInteger('id_peminjaman')->nullable();
            $table->unsignedInteger('id_serah_terima')->nullable();
            $table->dateTime('dibuat_pada')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('id_peminjaman')
                ->references('id_peminjaman')
                ->on('peminjaman')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreign('id_serah_terima')
                ->references('id_serah_terima')
                ->on('serah_terima')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('qr');
    }
};
