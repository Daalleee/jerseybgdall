<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Reset jersey slugs based on type
        $jerseys = \App\Models\Jersey::all();
        foreach ($jerseys as $jersey) {
            if ($jersey->type === 'sistem') {
                // Generate unique system jersey code (JS + 2 digits)
                do {
                    $code = 'JS' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                } while (\App\Models\Jersey::where('slug', $code)->where('id', '!=', $jersey->id)->exists());
                
                $jersey->update(['slug' => $code]);
            } else {
                // Generate unique customer jersey code (JC + 2 digits)
                do {
                    $code = 'JC' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                } while (\App\Models\Jersey::where('slug', $code)->where('id', '!=', $jersey->id)->exists());
                
                $jersey->update(['slug' => $code]);
            }
        }
        
        // Reset transaction codes based on type
        $transactions = \App\Models\Transaction::all();
        foreach ($transactions as $transaction) {
            if ($transaction->type === 'pembelian') {
                // Generate unique purchase transaction code (TP + 2 digits)
                do {
                    $code = 'TP' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
                } while (\App\Models\Transaction::where('transaction_code', $code)->where('id', '!=', $transaction->id)->exists());
                
                $transaction->update(['transaction_code' => $code]);
            } else {
                // Generate unique sale transaction code (TS + 2 digits)
                do {
                    $code = 'TS' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
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
        // Reset to original numeric IDs (this is just for rollback, actual rollback would be manual)
        // In a real-world scenario, you'd need to have a backup or manual process to restore original values
    }
};
