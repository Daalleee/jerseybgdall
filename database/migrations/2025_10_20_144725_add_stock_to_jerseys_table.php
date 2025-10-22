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
        Schema::table('jerseys', function (Blueprint $table) {
            $table->integer('stock')->default(1); // Menyimpan jumlah stok jersey, default 1
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jerseys', function (Blueprint $table) {
            $table->dropColumn('stock');
        });
    }
};
