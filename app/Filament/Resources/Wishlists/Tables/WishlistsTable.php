<?php

namespace App\Filament\Resources\Wishlists\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use App\Enums\Visibility;
use App\Enums\EditPermission;

class WishlistsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Владелец')
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Название')
                    ->searchable(),
                TextColumn::make('items.title')
                    ->label('Элементы')
                    ->listWithLineBreaks()
                    ->limitList(3) // Показывать только первые 3 элемента
                    ->expandableLimitedList(), // Раскрывать по клику
                TextColumn::make('visibility')
                    ->label('Видимость')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state->getLabel()) // Убрали Visibility::from()
                    ->color(fn($state) => $state->getColor()), // Убрали Visibility::from()
                TextColumn::make('edit_permission')
                    ->label('Права редактирования')
                    ->badge()
                    ->formatStateUsing(fn($state) => $state->getLabel()) // Убрали EditPermission::from()
                    ->color(fn($state) => $state->getColor()), // Убрали EditPermission::from()
                TextColumn::make('sort_order')
                    ->label('Сортировка')
                    ->numeric()
                    ->sortable(),
                IconColumn::make('is_archived')
                    ->label('В архиве')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
