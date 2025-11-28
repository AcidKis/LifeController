<?php

namespace App\Models;

use App\Enums\Visibility;
use App\Enums\EditPermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Wishlist extends Model
{
    use HasFactory;

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

    public function editors(): HasMany
    {
        return $this->hasMany(WishlistEditor::class);
    }
    public function getTotalItemsAttribute(): int
    {
        return $this->items()->count();
    }

    public function getCompletedItemsAttribute(): int
    {
        return $this->items()->where('completed', true)->count();
    }

    public function getProgressPercentageAttribute(): int
    {
        $total = $this->total_items;
        if ($total === 0) {
            return 0;
        }

        $completed = $this->completed_items;
        return (int) round(($completed / $total) * 100);
    }
    public function viewers(): HasMany
    {
        return $this->hasMany(WishlistViewer::class);
    }

    public function editorUsers()
    {
        return $this->belongsToMany(User::class, 'wishlist_editors', 'wishlist_id', 'user_id');
    }

    public function viewerUsers()
    {
        return $this->belongsToMany(User::class, 'wishlist_viewers', 'wishlist_id', 'user_id');
    }

    public function canEdit(User $user): bool
    {
        if ($this->user_id === $user->id) {
            return true;
        }

        if ($this->edit_permission === EditPermission::SELECTED) {
            return $this->editorUsers()->where('user_id', $user->id)->exists();
        }

        return false;
    }

    public function canView(User $user): bool
    {
        if ($this->user_id === $user->id) {
            return true;
        }

        if ($this->visibility === Visibility::PUBLIC) {
            return true;
        }

        if ($this->visibility === Visibility::SHARED) {
            return $this->viewerUsers()->where('user_id', $user->id)->exists();
        }

        return false;
    }

    public function scopeActive($query)
    {
        return $query->where('is_archived', false);
    }

    public function scopeArchived($query)
    {
        return $query->where('is_archived', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at');
    }
}
