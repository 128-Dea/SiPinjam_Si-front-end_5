<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('qr', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->after('qr_code');
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->enum('status', ['berlangsung', 'selesai', 'dibatalkan'])
                ->default('berlangsung')
                ->after('alasan');
        });

        Schema::table('serah_terima', function (Blueprint $table) {
            $table->enum('status_persetujuan', ['menunggu', 'disetujui', 'ditolak'])
                ->default('menunggu')
                ->after('catatan');
        });

        Schema::table('barang', function (Blueprint $table) {
            $table->bigInteger('harga')->nullable()->after('kode_barang');
        });
    }


    public function down(): void
    {
        Schema::table('qr', function (Blueprint $table) {
            $table->dropColumn('is_active');
        });

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->dropColumn('status');
        });

        Schema::table('serah_terima', function (Blueprint $table) {
            $table->dropColumn('status_persetujuan');
        });

        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn('harga');
        });
    }
};
