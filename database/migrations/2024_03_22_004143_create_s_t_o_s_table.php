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
        Schema::create('sto', function (Blueprint $table) {
            $table->id();
            $table->string('kode_js');
            $table->integer('qty');
            $table->integer('actual_qty');
            $table->timestamps();

            $table->foreign('kode_js')->references('kode_js')->on('barang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sto');
    }
};
