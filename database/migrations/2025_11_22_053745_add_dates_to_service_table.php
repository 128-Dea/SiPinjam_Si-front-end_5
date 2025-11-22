<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service', function (Blueprint $table) {
            // tanggal barang mulai masuk service
            $table->dateTime('tgl_masuk_service')
                  ->nullable()
                  ->after('status');

            // estimasi kapan service selesai
            $table->dateTime('estimasi_selesai')
                  ->nullable()
                  ->after('tgl_masuk_service');
        });
    }

    public function down(): void
    {
        Schema::table('service', function (Blueprint $table) {
            $table->dropColumn(['tgl_masuk_service', 'estimasi_selesai']);
        });
    }
};
