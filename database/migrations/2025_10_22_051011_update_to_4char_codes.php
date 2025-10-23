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
        // Update jersey codes to 4-character format
        $jerseys = \App\Models\Jersey::all();
        foreach ($jerseys as $jersey) {
            if ($jersey->type === 'sistem') {
                // Generate unique 4-character system jersey code (JS + 2 digits)
                $attempts = 0;
                do {
                    $number = rand(1, 99);
                    $code = 'JS' . str_pad($number, 2, '0', STR_PAD_LEFT);
                    $attempts++;
                    // Prevent infinite loops
                    if ($attempts > 10000) break;
                } while (\App\Models\Jersey::where('slug', $code)->where('id', '!=', $jersey->id)->exists());
                
                $jersey->update(['slug' => $code]);
            } else {
                // Generate unique 4-character customer jersey code (JC + 2 digits)
                $attempts = 0;
                do {
                    $number = rand(1, 99);
                    $code = 'JC' . str_pad($number, 2, '0', STR_PAD_LEFT);
                    $attempts++;
                    // Prevent infinite loops
                    if ($attempts > 10000) break;
                } while (\App\Models\Jersey::where('slug', $code)->where('id', '!=', $jersey->id)->exists());
                
                $jersey->update(['slug' => $code]);
            }
        }
        
        // Update transaction codes to 4-character format
        $transactions = \App\Models\Transaction::all();
        foreach ($transactions as $transaction) {
            if ($transaction->type === 'pembelian') {
                // Generate unique 4-character purchase transaction code (TP + 2 digits)
                $attempts = 0;
                do {
                    $number = rand(1, 99);
                    $code = 'TP' . str_pad($number, 2, '0', STR_PAD_LEFT);
                    $attempts++;
                    // Prevent infinite loops
                    if ($attempts > 10000) break;
                } while (\App\Models\Transaction::where('transaction_code', $code)->where('id', '!=', $transaction->id)->exists());
                
                $transaction->update(['transaction_code' => $code]);
            } else {
                // Generate unique 4-character sale transaction code (TS + 2 digits)
                $attempts = 0;
                do {
                    $number = rand(1, 99);
                    $code = 'TS' . str_pad($number, 2, '0', STR_PAD_LEFT);
                    $attempts++;
                    // Prevent infinite loops
                    if ($attempts > 10000) break;
                } while (\App\Models\Transaction::where('transaction_code', $code)->where('id', '!=', $transaction->id)->exists());
                
                $transaction->update(['transaction_code' => $code]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original codes would require a backup
        // For now, this is a no-op since we don't have original codes to revert to
    }
};
