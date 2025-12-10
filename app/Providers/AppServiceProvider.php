<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Policies\WishlistPolicy;
use App\Policies\WishlistItemPolicy;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Gate::define('view-wishlist', [WishlistPolicy::class, 'view']);
        Gate::define('update-wishlist', [WishlistPolicy::class, 'update']);
        Gate::define('delete-wishlist', [WishlistPolicy::class, 'delete']);
        Gate::define('add-item-to-wishlist', [WishlistPolicy::class, 'addItem']);
        Gate::define('manage-wishlist-permissions', [WishlistPolicy::class, 'managePermissions']);

        Gate::define('update-wishlist-item', [WishlistItemPolicy::class, 'update']);
        Gate::define('delete-wishlist-item', [WishlistItemPolicy::class, 'delete']);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
