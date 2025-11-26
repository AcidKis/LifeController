<?php

namespace App\Filament\Resources\Wishlists\Schemas;

use App\Enums\EditPermission;
use App\Enums\Visibility;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class WishlistForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required()
                    ->selectablePlaceholder(false),
                TextInput::make('title')
                    ->required(),
                Textarea::make('description')
                    ->columnSpanFull(),
                Select::make('visibility')
                    ->options(Visibility::class)
                    ->default('private')
                    ->required()
                    ->selectablePlaceholder(false),
                Select::make('edit_permission')
                    ->options(EditPermission::class)
                    ->default('owner')
                    ->required()
                    ->selectablePlaceholder(false),

                Select::make('viewerUsers')
                    ->relationship('viewerUsers', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->visibleJs(<<<'JS'
                        $get('visibility') === 'shared'
                    JS)
                    ->helperText('Выберите пользователей, которым будет доступен просмотр вишлиста'),

                Select::make('editorUsers')
                    ->relationship('editorUsers', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->visibleJs(<<<'JS'
                        $get('edit_permission') === 'selected'
                    JS)
                    ->helperText('Выберите пользователей, которым будет доступно редактирование вишлиста'),

                TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(100),
                    
                Toggle::make('is_archived')
                    ->required(),
            ]);
    }
}
