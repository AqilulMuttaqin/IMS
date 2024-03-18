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
        Schema::table('perubahan', function (Blueprint $table) {
            $table->string('remark')->nullable()->change();
            $table->integer('qty_awal')->nullable()->change();
            $table->integer('qty_akhir')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perubahan', function (Blueprint $table) {
            $table->enum('remark', ['Keluar', 'Masuk'])->change();
            $table->integer('qty_awal')->change();
            $table->integer('qty_akhir')->change();
        });
    }
};
