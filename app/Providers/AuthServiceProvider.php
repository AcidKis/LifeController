<?php

namespace App\Providers;

use App\Models\Wishlist;
use App\Models\WishlistItem;
use App\Policies\WishlistPolicy;
use App\Policies\WishlistItemPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{


    public function boot(): void
    {
     
    }
}