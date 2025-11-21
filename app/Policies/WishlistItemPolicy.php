<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WishlistItem;

class WishlistItemPolicy
{
    public function view(User $user, WishlistItem $item): bool
    {
        return $item->wishlist->canView($user);
    }

    public function update(User $user, WishlistItem $item): bool
    {
        return $item->wishlist->canEdit($user);
    }

    public function delete(User $user, WishlistItem $item): bool
    {
        return $item->wishlist->canEdit($user);
    }

    public function complete(User $user, WishlistItem $item): bool
    {
        return $item->wishlist->canEdit($user);
    }
}