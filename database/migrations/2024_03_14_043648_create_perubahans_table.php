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
            $table->foreignId('data_barang_id')->constrained('data_barang')->onDelete('cascade');
            $table->foreignId('lokasi_awal_id')->nullable()->constrained('lokasi')->onDelete('set null');
            $table->foreignId('lokasi_akhir_id')->nullable()->constrained('lokasi')->onDelete('set null');
            $table->string('remark');
            $table->integer('qty');
            $table->integer('qty_awal')->nullable();
            $table->integer('qty_akhir')->nullable();
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
