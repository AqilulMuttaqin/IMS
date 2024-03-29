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
        Schema::table('barang', function (Blueprint $table) {
            $table->decimal('min_stok', 10, 2)->default(0)->change();
            $table->decimal('max_stok', 10, 2)->default(0)->change();
            $table->decimal('requested_qty', 10, 2)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->integer('min_stok')->default(0)->change();
            $table->integer('max_stok')->default(0)->change();
            $table->integer('requested_qty')->default(0)->change();
        });
    }
};
