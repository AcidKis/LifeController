<?php

namespace App\Models;

use App\Enums\Visibility;
use App\Enums\EditPermission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'visibility',
        'edit_permission',
        'sort_order',
        'is_archived',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
        'sort_order' => 'integer',
        'visibility' => Visibility::class,
        'edit_permission' => EditPermission::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function editorUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlist_editors');
    }

    public function viewerUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'wishlist_viewers');
    }

    // Accessors

    protected $appends = ['progress_percentage'];

    public function getProgressPercentageAttribute(): int
    {
        return $this->items_count > 0
            ? round(($this->completed_items_count / $this->items_count) * 100)
            : 0;
    }

    public function scopeForUser(Builder $query, User $user): Builder
    {
        return $query->where(function (Builder $q) use ($user) {
            $q->where('user_id', $user->id)
                ->orWhere('visibility', Visibility::PUBLIC)
                ->orWhereHas('editorUsers', fn($q) => $q->where('user_id', $user->id))
                ->orWhereHas('viewerUsers', fn($q) => $q->where('user_id', $user->id));
        });
    }

    public function scopeWithProgress(Builder $query): Builder
    {
        return $query->withCount([
            'items',
            'items as completed_items_count' => fn($query) => $query->where('completed', true)
        ]);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_archived', false);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }
}
