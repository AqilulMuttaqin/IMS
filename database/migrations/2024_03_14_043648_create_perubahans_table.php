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
            $table->foreignId('id_data_barang')->constrained('data_barang')->onDelete('cascade');
            $table->foreignId('lokasi_awal_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->foreignId('lokasi_akhir_id')->nullable()->constrained('locations')->onDelete('set null');
            $table->enum('remark', ['Keluar', 'Masuk']);
            $table->integer('qty');
            $table->integer('qty_awal');
            $table->integer('qty_akhir');
            $table->timestamps();
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
