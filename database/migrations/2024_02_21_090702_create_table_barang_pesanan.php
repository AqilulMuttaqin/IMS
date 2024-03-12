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
        Schema::create('barang_pesanan', function (Blueprint $table) {
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');
            $table->string('kode_js');
            $table->integer('qty');
            $table->enum('keterangan' , ['request', 'tukar'])->default('request');
            $table->timestamps();
            $table->foreign('kode_js')->references('kode_js')->on('barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_pesanan');
    }
};
