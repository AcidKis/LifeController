<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WishlistItem;

class WishlistItemPolicy
{
    public function view(User $user, WishlistItem $item): bool
    {
        return true;
    }

    public function update(User $user, WishlistItem $item): bool
    {
        return true;
    }

    public function delete(User $user, WishlistItem $item): bool
    {
        return true;
    }

    public function complete(User $user, WishlistItem $item): bool
    {
        return true;
    }
}