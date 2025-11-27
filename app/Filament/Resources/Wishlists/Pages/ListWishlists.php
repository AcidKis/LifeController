<?php

namespace App\Filament\Resources\Wishlists\Pages;

use App\Filament\Resources\Wishlists\WishlistResource;
use App\Models\Wishlist;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListWishlists extends ListRecords
{
    protected static string $resource = WishlistResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
    public function getTabs(): array
    {
        return [
            'Все' => Tab::make()
            ->badge(Wishlist::query()->count()),
            'Активные' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_archived', false))
                ->badge(Wishlist::query()->where('is_archived', false)->count()),
            'В архиве' => Tab::make()
                ->modifyQueryUsing(fn(Builder $query) => $query->where('is_archived', true))
                ->badge(Wishlist::query()->where('is_archived', true)->count()),
        ];
    }
}
