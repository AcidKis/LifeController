<?php

namespace App\Filament\Resources\Wishlists\Schemas;

use App\Enums\Visibility;
use App\Enums\EditPermission;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class WishlistForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->label('Владелец вишлиста')
                    ->required(),
                
                TextInput::make('title')
                    ->label('Название вишлиста')
                    ->required()
                    ->maxLength(255),
                
                Textarea::make('description')
                    ->label('Описание вишлиста')
                    ->columnSpanFull()
                    ->maxLength(1000),
                
                Select::make('visibility')
                    ->options(Visibility::class)
                    ->label('Уровень видимости')
                    ->required()
                    ->default(Visibility::PRIVATE->value)
                    ->native(false)
                    ->live() // Изменено с reactive на live
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state !== Visibility::SHARED->value) {
                            $set('viewer_users', []);
                        }
                    }),
                
                Select::make('edit_permission')
                    ->options(EditPermission::class)
                    ->label('Кто может редактировать')
                    ->required()
                    ->default(EditPermission::OWNER->value)
                    ->native(false)
                    ->live() // Изменено с reactive на live
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state !== EditPermission::SELECTED->value) {
                            $set('editor_users', []);
                        }
                    }),
                
                // Поле для выбора пользователей с доступом на просмотр (только для shared)
                Select::make('viewer_users')
                    ->label('Пользователи с доступом на просмотр')
                    ->multiple()
                    ->relationship(
                        name: 'viewerUsers',
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('users.id', '!=', auth()->id())
                    )
                    ->searchable()
                    ->preload()
                    ->live() // Добавлено live
                    ->visible(fn (callable $get) => $get('visibility') === Visibility::SHARED->value)
                    ->helperText('Выберите пользователей, которым будет доступен этот вишлист')
                    ->columnSpanFull(),
                
                // Поле для выбора пользователей с доступом на редактирование (только для selected)
                Select::make('editor_users')
                    ->label('Пользователи с доступом на редактирование')
                    ->multiple()
                    ->relationship(
                        name: 'editorUsers', 
                        titleAttribute: 'name',
                        modifyQueryUsing: fn (Builder $query) => $query->where('users.id', '!=', auth()->id())
                    )
                    ->searchable()
                    ->preload()
                    ->live() // Добавлено live
                    ->visible(fn (callable $get) => $get('edit_permission') === EditPermission::SELECTED->value)
                    ->helperText('Выберите пользователей, которые смогут редактировать этот вишлист')
                    ->columnSpanFull(),
                
                TextInput::make('sort_order')
                    ->label('Порядок сортировки')
                    ->required()
                    ->numeric()
                    ->default(100)
                    ->minValue(0),
                
                Toggle::make('is_archived')
                    ->label('Переместить в архив')
                    ->required()
                    ->default(false),
            ]);
    }
}