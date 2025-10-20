<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
    ];

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
}
