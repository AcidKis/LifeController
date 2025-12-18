<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Wishlist;
use App\Enums\Visibility;
use App\Enums\EditPermission;

class WishlistPolicy
{
    public function view(User $user, Wishlist $wishlist): bool
    {
        if ($wishlist->user_id === $user->id) {
            return true;
        }

        if ($wishlist->visibility === Visibility::PUBLIC) {
            return true;
        }

        if ($wishlist->visibility === Visibility::SHARED) {
            return $wishlist->viewerUsers()->where('user_id', $user->id)->exists();
        }

        return false;
    }

    public function update(User $user, Wishlist $wishlist): bool
    {
        if ($wishlist->user_id === $user->id) {
            return true;
        }

        if ($wishlist->edit_permission === EditPermission::SELECTED) {
            return $wishlist->editorUsers()->where('user_id', $user->id)->exists();
        }

        return false;
    }

    /**
     * Проверка на удаление вишлиста (только владелец)
     */
    public function delete(User $user, Wishlist $wishlist): bool
    {
        return $wishlist->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        // Любой аутентифицированный пользователь может создавать вишлисты
        return true;
    }

    /**
     * Проверка на добавление элементов
     */
    public function addItem(User $user, Wishlist $wishlist): bool
    {
        return $this->update($user, $wishlist);
    }

    /**
     * Проверка на управление разрешениями (только владелец)
     */
    public function managePermissions(User $user, Wishlist $wishlist): bool
    {
        return $wishlist->user_id === $user->id;
    }

    /**
     * Проверка, может ли пользователь управлять редакторами
     */
    public function manageEditors(User $user, Wishlist $wishlist): bool
    {
        return $this->managePermissions($user, $wishlist);
    }

    /**
     * Проверка, может ли пользователь управлять зрителями
     */
    public function manageViewers(User $user, Wishlist $wishlist): bool
    {
        return $this->managePermissions($user, $wishlist);
    }
}