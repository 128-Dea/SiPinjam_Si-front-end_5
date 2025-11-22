<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('service', function (Blueprint $table) {
            $table->unsignedInteger('id_barang')->after('id_service');
            $table->foreign('id_barang')
                ->references('id_barang')
                ->on('barang')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('service', function (Blueprint $table) {
            $table->dropForeign(['id_barang']);
            $table->dropColumn('id_barang');
        });
    }
};
