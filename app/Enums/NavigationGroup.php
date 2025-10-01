<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum NavigationGroup: string implements HasLabel
{
    case Users = 'users';
    case Blog = 'blog';
    case Settings = 'settings';

    public function getLabel(): string
    {
        return match ($this) {
            self::Blog => 'Blog',
            self::Users => 'Users',
            self::Settings => 'Settings',
        };
    }

    public static function values(): array
    {
        return array_map(fn (self $group) => $group->value, self::cases());
    }
}
