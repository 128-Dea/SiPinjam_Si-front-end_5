<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('riwayat', function (Blueprint $table) {
            $table->increments('id_riwayat');
            $table->unsignedInteger('id_pengembalian');
            $table->enum('serah_terima', ['ya', 'tidak'])->default('tidak');
            $table->decimal('denda', 10, 2);

            $table->foreign('id_pengembalian')
                ->references('id_pengembalian')
                ->on('pengembalian')
                ->cascadeOnUpdate()
                ->restrictOnDelete();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('riwayat');
    }
};
