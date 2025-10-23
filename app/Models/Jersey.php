<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Transaction;

class Jersey extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'size',
        'condition',
        'photo', // Foto utama tetap disimpan di sini
        'additional_photos', // Array JSON untuk foto tambahan
        'address',
        'phone_number',
        'status',
        'type',
        'user_id',
        'sizes',
        'stock',
        'slug',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sizes' => 'array', // Casting untuk menyimpan array ukuran
        'additional_photos' => 'array', // Casting untuk menyimpan array foto tambahan
    ];

    /**
     * Boot the model and set up events
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($jersey) {
            if ($jersey->type === 'sistem') {
                $jersey->slug = static::generateSystemJerseyCode();
            } else {
                $jersey->slug = static::generateCustomerJerseyCode();
            }
        });
    }

    /**
     * Generate a unique system jersey code (JS + 2 digits)
     */
    protected static function generateSystemJerseyCode()
    {
        $attempts = 0;
        do {
            $number = rand(1, 99);
            $code = 'JS' . str_pad($number, 2, '0', STR_PAD_LEFT);
            $attempts++;
            // Prevent infinite loops
            if ($attempts > 10000) break;
        } while (static::where('slug', $code)->exists());

        return $code;
    }

    /**
     * Generate a unique customer jersey code (JC + 2 digits)
     */
    protected static function generateCustomerJerseyCode()
    {
        $attempts = 0;
        do {
            $number = rand(1, 99);
            $code = 'JC' . str_pad($number, 2, '0', STR_PAD_LEFT);
            $attempts++;
            // Prevent infinite loops
            if ($attempts > 10000) break;
        } while (static::where('slug', $code)->exists());

        return $code;
    }

    /**
     * Accessor untuk additional_photos
     */
    public function getAdditionalPhotosAttribute($value)
    {
        // Jika value adalah string JSON, decode dulu
        if (is_string($value)) {
            $decoded = json_decode($value, true);
            return is_array($decoded) ? $decoded : [];
        }
        
        // Jika value adalah array, kembalikan langsung
        if (is_array($value)) {
            return $value;
        }
        
        // Jika tidak ada value, kembalikan array kosong
        return [];
    }

    /**
     * Relasi ke user (penjual jersey)
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke transaksi
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class, 'jersey_id');
    }

    /**
     * Scope untuk jersey aktif saja
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }
    
    /**
     * Scope untuk jersey sistem yang aktif
     */
    public function scopeSistemAktif($query)
    {
        return $query->where('status', 'aktif')->where('type', 'sistem');
    }
    
    /**
     * Scope untuk jersey pelanggan yang disetujui
     */
    public function scopePelangganDisetujui($query)
    {
        return $query->where('status', 'aktif')->where('type', 'pelanggan');
    }

    /**
     * Cek apakah jersey milik sistem
     */
    public function isSystemJersey(): bool
    {
        return $this->type === 'sistem';
    }

    /**
     * Cek apakah jersey dari pelanggan
     */
    public function isCustomerJersey(): bool
    {
        return $this->type === 'pelanggan';
    }
    
    /**
     * Scope untuk jersey dari sistem (admin)
     */
    public function scopeFromSystem($query)
    {
        return $query->where('type', 'sistem');
    }
    
    /**
     * Scope untuk jersey dari pelanggan
     */
    public function scopeFromCustomer($query)
    {
        return $query->where('type', 'pelanggan');
    }
    
    /**
     * Mendapatkan ukuran tersedia dalam bentuk string
     */
    public function getAvailableSizesAttribute(): string
    {
        if (!$this->sizes) {
            return $this->size; // Fallback ke field size lama
        }
        
        // Jika sizes berupa string (JSON dari database), decode dulu
        $sizesArray = is_string($this->sizes) ? json_decode($this->sizes, true) : $this->sizes;
        
        if (!is_array($sizesArray)) {
            return $this->size; // Fallback jika decode gagal
        }
        
        return implode(', ', $sizesArray);
    }
    
    /**
     * Cek apakah ukuran tersedia
     */
    public function hasSize(string $size): bool
    {
        if (!$this->sizes) {
            return $this->size === $size; // Fallback ke field size lama
        }
        
        // Jika sizes berupa string (JSON dari database), decode dulu
        $sizesArray = is_string($this->sizes) ? json_decode($this->sizes, true) : $this->sizes;
        
        if (!is_array($sizesArray)) {
            return $this->size === $size; // Fallback jika decode gagal
        }
        
        return in_array($size, $sizesArray);
    }
    
    /**
     * Mendapatkan semua foto jersey
     */
    public function getAllPhotosAttribute(): array
    {
        $photos = [];
        
        // Tambahkan foto utama jika ada
        if ($this->photo) {
            $photos[] = $this->photo;
        }
        
        // Tambahkan foto tambahan jika ada
        if ($this->additional_photos && is_array($this->additional_photos)) {
            $photos = array_merge($photos, $this->additional_photos);
        }
        
        return $photos;
    }
    
    /**
     * Mendapatkan status yang ditampilkan berdasarkan tipe jersey
     */
    public function getDisplayStatusAttribute(): string
    {
        if ($this->type === 'pelanggan') {
            return $this->status === 'aktif' ? 'Disetujui' : 
                   ($this->status === 'pending_review' ? 'Menunggu Review' : 'Ditolak');
        } else {
            return $this->status === 'aktif' ? 'Aktif' : 
                   ($this->status === 'pending_review' ? 'Menunggu Review' : 'Ditolak');
        }
    }
    
    /**
     * Cek apakah stok tersedia
     */
    public function hasStock(int $quantity = 1): bool
    {
        return $this->stock >= $quantity;
    }
    
    /**
     * Kurangi stok jersey
     */
    public function reduceStock(int $quantity = 1): void
    {
        if ($this->hasStock($quantity)) {
            $this->update(['stock' => $this->stock - $quantity]);
        }
    }

    /**
     * Get the route key for Laravel model binding
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
