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
            $table->string('slug')->nullable(); // Add slug column first as nullable
        });
        
        // Populate slug values for existing records
        $jerseys = \App\Models\Jersey::all();
        foreach ($jerseys as $jersey) {
            $slug = \Illuminate\Support\Str::slug($jersey->name) . '-' . $jersey->id;
            $jersey->update(['slug' => $slug]);
        }
        
        // Add unique index for slug
        Schema::table('jerseys', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jerseys', function (Blueprint $table) {
            $table->dropUnique(['slug']); // Drop unique index first
            $table->dropColumn('slug');
        });
    }
};
