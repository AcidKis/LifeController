<?php

namespace App\Filament\Resources\Wishlists\Pages;

use App\Filament\Resources\Wishlists\WishlistResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWishlist extends CreateRecord
{
    protected static string $resource = WishlistResource::class;
    public function getTitle(): string
    {
        return 'Создание нового вишлиста';
    }

    public function getHeading(): string
    {
        return 'Создание нового вишлиста';
    }
}
