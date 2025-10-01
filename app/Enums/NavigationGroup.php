<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum NavigationGroup: string implements HasLabel
{
    case Blog = 'blog';
    case Users = 'users';
    case Settings = 'settings';

    public function getLabel(): string
    {
        return match ($this) {
            self::Blog => 'Blog',
            self::Users => 'Users',
            self::Settings => 'Settings',
        };
    }
}
