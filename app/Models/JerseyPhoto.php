<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Jersey;

class JerseyPhoto extends Model
{
    protected $fillable = [
        'jersey_id',
        'photo_path',
    ];

    /**
     * Relasi ke jersey
     */
    public function jersey(): BelongsTo
    {
        return $this->belongsTo(Jersey::class, 'jersey_id');
    }
}
