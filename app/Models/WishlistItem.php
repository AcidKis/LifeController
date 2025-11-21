<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WishlistItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'wishlist_id',
        'sort_order',
        'completed',
        'title',
        'description',
        'price',
        'url',
        'image',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'sort_order' => 'integer',
        'price' => 'decimal:2',
    ];

    public function wishlist(): BelongsTo
    {
        return $this->belongsTo(Wishlist::class);
    }

    public function scopeCompleted($query)
    {
        return $query->where('completed', true);
    }

    public function scopeIncomplete($query)
    {
        return $query->where('completed', false);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }

    public function scopeExpensive($query, $amount = 1000)
    {
        return $query->where('price', '>', $amount);
    }

    public function hasLink(): bool
    {
        return !empty($this->url);
    }

    public function hasImage(): bool
    {
        return !empty($this->image);
    }
}