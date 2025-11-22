<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('denda', function (Blueprint $table) {
            $table->string('metode_pembayaran', 20)
                  ->nullable()
                  ->after('status_pembayaran');

            $table->string('bukti_transfer_path')
                  ->nullable()
                  ->after('metode_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('denda', function (Blueprint $table) {
            $table->dropColumn('metode_pembayaran');
            $table->dropColumn('bukti_transfer_path');
        });
    }
};
