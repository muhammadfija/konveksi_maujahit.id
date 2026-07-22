<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductionProgress extends Model
{
    protected $table = 'production_progresses';

    protected $fillable = [
        'order_id',
        'status',
        'photo_path',
        'note',
        'created_by',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (!$this->photo_path) return null;
        return asset('storage/' . $this->photo_path);
    }
}
