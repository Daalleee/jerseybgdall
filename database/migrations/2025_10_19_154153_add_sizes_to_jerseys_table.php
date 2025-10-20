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
            $table->json('sizes')->nullable(); // Menyimpan ukuran-ukuran yang tersedia dalam format JSON
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jerseys', function (Blueprint $table) {
            $table->dropColumn('sizes');
        });
    }
};
