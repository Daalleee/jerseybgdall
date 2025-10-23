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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('transaction_code')->nullable(); // Add transaction_code column first as nullable
        });
        
        // Populate transaction_code values for existing records
        $transactions = \App\Models\Transaction::all();
        foreach ($transactions as $transaction) {
            $code = 'TRX-' . strtoupper(\Illuminate\Support\Str::random(8));
            // Ensure uniqueness
            while (\App\Models\Transaction::where('transaction_code', $code)->exists()) {
                $code = 'TRX-' . strtoupper(\Illuminate\Support\Str::random(8));
            }
            $transaction->update(['transaction_code' => $code]);
        }
        
        // Add unique index for transaction_code
        Schema::table('transactions', function (Blueprint $table) {
            $table->unique('transaction_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropUnique(['transaction_code']); // Drop unique index first
            $table->dropColumn('transaction_code');
        });
    }
};
