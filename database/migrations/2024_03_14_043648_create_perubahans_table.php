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
        Schema::create('perubahan', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('id_data_barang')->constrained('data_barang')->onDelete('cascade');
            $table->string('lokasi_awal');
            $table->string('lokasi_akhir');
            $table->integer('qty');
            $table->integer('qty_awal');
            $table->integer('qty_akhir');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perubahan');
    }
};
