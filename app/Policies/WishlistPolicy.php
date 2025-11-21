<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wishlist;

class WishlistPolicy
{
    public function view(User $user, Wishlist $wishlist): bool
    {
        return $wishlist->canView($user);
    }

    public function update(User $user, Wishlist $wishlist): bool
    {
        return $wishlist->canEdit($user);
    }

    public function delete(User $user, Wishlist $wishlist): bool
    {
        return $wishlist->user_id === $user->id;
    }

    public function addItem(User $user, Wishlist $wishlist): bool
    {
        return $wishlist->canEdit($user);
    }

    public function manageEditors(User $user, Wishlist $wishlist): bool
    {
        return $wishlist->user_id === $user->id;
    }

    public function manageViewers(User $user, Wishlist $wishlist): bool
    {
        return $wishlist->user_id === $user->id;
    }
}