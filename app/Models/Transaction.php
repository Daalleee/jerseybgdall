<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Jersey;

class Transaction extends Model
{
    protected $fillable = [
        'jersey_id',
        'user_id',
        'buyer_address',
        'buyer_phone',
        'payment_proof',
        'type',
        'status',
        'transaction_code',
    ];

    /**
     * Boot the model and set up events
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if ($transaction->type === 'pembelian') {
                $transaction->transaction_code = static::generatePurchaseTransactionCode();
            } else {
                $transaction->transaction_code = static::generateSaleTransactionCode();
            }
        });
    }

    /**
     * Generate a unique purchase transaction code (TP + 2 digits)
     */
    protected static function generatePurchaseTransactionCode()
    {
        $attempts = 0;
        do {
            $number = rand(1, 99);
            $code = 'TP' . str_pad($number, 2, '0', STR_PAD_LEFT);
            $attempts++;
            // Prevent infinite loops
            if ($attempts > 10000) break;
        } while (static::where('transaction_code', $code)->exists());

        return $code;
    }

    /**
     * Generate a unique sale transaction code (TS + 2 digits)
     */
    protected static function generateSaleTransactionCode()
    {
        $attempts = 0;
        do {
            $number = rand(1, 99);
            $code = 'TS' . str_pad($number, 2, '0', STR_PAD_LEFT);
            $attempts++;
            // Prevent infinite loops
            if ($attempts > 10000) break;
        } while (static::where('transaction_code', $code)->exists());

        return $code;
    }

    /**
     * Relasi ke jersey
     */
    public function jersey(): BelongsTo
    {
        return $this->belongsTo(Jersey::class, 'jersey_id');
    }

    /**
     * Relasi ke user (pembeli)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Cek apakah transaksi adalah pembelian
     */
    public function isPurchase(): bool
    {
        return $this->type === 'pembelian';
    }

    /**
     * Cek apakah transaksi adalah penjualan
     */
    public function isSale(): bool
    {
        return $this->type === 'penjualan';
    }

    /**
     * Cek apakah transaksi pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Cek apakah transaksi selesai
     */
    public function isCompleted(): bool
    {
        return $this->status === 'selesai';
    }

    /**
     * Cek apakah transaksi ditolak
     */
    public function isRejected(): bool
    {
        return $this->status === 'ditolak';
    }

    /**
     * Get the route key for Laravel model binding
     */
    public function getRouteKeyName()
    {
        return 'transaction_code';
    }
}
