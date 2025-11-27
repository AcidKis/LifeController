<?php

namespace App\Filament\Resources\Wishlists\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class WishlistsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sort_order')
                    ->label('Сортировка')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('user.name')
                    ->label('Владелец')
                    ->searchable(),
                TextColumn::make('title')
                    ->label('Название вишлиста')
                    ->searchable(),
                TextColumn::make('visibility')
                    ->label('Права видимости')
                    ->badge()
                    ->searchable(),
                TextColumn::make('edit_permission')
                    ->label('Права редактирования')
                    ->badge()
                    ->searchable(),
                IconColumn::make('is_archived')
                    ->label('В архиве?')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Создан')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Обновлен')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
