<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum Visibility: string implements HasLabel, HasColor
{
    case PRIVATE = 'private';
    case PUBLIC = 'public';
    case SHARED = 'shared';

    public function getLabel(): string
    {
        return match ($this) {
            self::PRIVATE => 'Приватный',
            self::PUBLIC => 'Для всех',
            self::SHARED => 'Доступно некоторым',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PRIVATE => 'gray',
            self::PUBLIC => 'success',
            self::SHARED => 'warning',
        };
    }
}