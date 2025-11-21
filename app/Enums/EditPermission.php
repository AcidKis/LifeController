<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum EditPermission: string implements HasLabel, HasColor
{
    case OWNER = 'owner';
    case SELECTED = 'selected';

    public function getLabel(): string
    {
        return match ($this) {
            self::OWNER => 'Только владелец',
            self::SELECTED => 'Выбранные пользователи',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::OWNER => 'primary',
            self::SELECTED => 'info',
        };
    }
}