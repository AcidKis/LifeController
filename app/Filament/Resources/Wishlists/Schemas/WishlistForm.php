<?php

namespace App\Filament\Resources\Wishlists\Schemas;

use App\Enums\EditPermission;
use App\Enums\Visibility;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Grid;

class WishlistForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Владелец вишлиста')
                    ->relationship('user', 'name')
                    ->required()
                    ->selectablePlaceholder(false),

                TextInput::make('title')
                    ->label('Название вишлиста')
                    ->required(),

                Textarea::make('description')
                    ->label('Описание вишлиста')
                    ->columnSpanFull(),

                Fieldset::make('Права просмотра')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('visibility')
                            ->label('Кто может просматривать')
                            ->options(Visibility::class)
                            ->default('private')
                            ->required()
                            ->selectablePlaceholder(false),

                        Select::make('viewerUsers')
                            ->label('Пользователи для просмотра')
                            ->relationship('viewerUsers', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->visibleJs(<<<'JS'
                                $get('visibility') === 'shared'
                            JS)
                            ->helperText('Выберите пользователей, которым будет доступен просмотр вишлиста'),
                    ]),

                Fieldset::make('Права редактирования')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('edit_permission')
                            ->label('Кто может редактировать')
                            ->options(EditPermission::class)
                            ->default('owner')
                            ->required()
                            ->selectablePlaceholder(false),

                        Select::make('editorUsers')
                            ->label('Пользователи для редактирования')
                            ->relationship('editorUsers', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->visibleJs(<<<'JS'
                                $get('edit_permission') === 'selected'
                            JS)
                            ->helperText('Выберите пользователей, которым будет доступно редактирование вишлиста'),
                    ]),

                TextInput::make('sort_order')
                    ->label('Сортировка')
                    ->required()
                    ->numeric()
                    ->default(100),

                Fieldset::make('Статус вишлиста')
                    ->columnSpanFull()
                    ->schema([
                        Toggle::make('is_archived')
                            ->label('Переместить в архив')
                            ->helperText('Архивные вишлисты будут скрыты из основного списка')
                            ->required()
                            ->inline(false)
                            ->extraAttributes(['class' => 'mx-auto']), // Центрирование внутри Fieldset
                    ])
                    ->extraAttributes(['class' => 'text-center']), // Центрирование всего Fieldset
            ]);
    }
}
