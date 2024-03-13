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
        Schema::create('barang', function (Blueprint $table) {
            $table->string('kode_js')->unique()->primary();
            $table->string('nama');
            $table->string('satuan');
            $table->decimal('harga', 15, 2);
            $table->integer('min_stok')->default(0);
            $table->integer('max_stok')->default(0);
            $table->enum('kategori', ['request', 'tukar']);
            $table->integer('requested_qty')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};
