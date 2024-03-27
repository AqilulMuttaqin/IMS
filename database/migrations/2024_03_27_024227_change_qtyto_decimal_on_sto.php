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
        Schema::table('sto', function (Blueprint $table) {
            $table->decimal('qty', 10, 2)->change();
            $table->decimal('actual_qty', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sto', function (Blueprint $table) {
            $table->integer('qty')->change();
            $table->integer('actual_qty')->change();
        });
    }
};
