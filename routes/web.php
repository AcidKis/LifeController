<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\WishlistItemController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Маршруты для вишлистов
Route::resource('wishlists', WishlistController::class)
    ->middleware(['auth']);

// Маршруты для элементов вишлиста
Route::get('/wishlist-items/{item}', [WishlistItemController::class, 'show'])
    ->name('wishlist-items.show')
    ->middleware('auth');

Route::post('/wishlist-items/{item}/toggle', [WishlistItemController::class, 'toggle'])
    ->name('wishlist-items.toggle')
    ->middleware('auth');

Route::post('/wishlist-items', [WishlistItemController::class, 'store'])
    ->name('wishlist-items.store')
    ->middleware('auth');

Route::put('/wishlist-items/{item}', [WishlistItemController::class, 'update'])
    ->name('wishlist-items.update')
    ->middleware('auth');

Route::delete('/wishlist-items/{item}', [WishlistItemController::class, 'destroy'])
    ->name('wishlist-items.destroy')
    ->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';