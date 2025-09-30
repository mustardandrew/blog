<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('User Details')
                    ->schema([
                        ImageEntry::make('avatar')
                            ->label('Avatar')
                            ->circular()
                            ->defaultImageUrl(fn ($record) => $record->getAvatarUrl())
                            ->size(100),

                        TextEntry::make('name')
                            ->label('Full Name'),
                        
                        TextEntry::make('email')
                            ->label('Email Address')
                            ->copyable(),
                        
                        IconEntry::make('is_admin')
                            ->label('Administrator')
                            ->boolean()
                            ->trueIcon(Heroicon::OutlinedCheckCircle)
                            ->falseIcon(Heroicon::OutlinedXCircle)
                            ->trueColor('success')
                            ->falseColor('gray'),
                        
                        TextEntry::make('email_verified_at')
                            ->label('Email Verified At')
                            ->dateTime()
                            ->placeholder('Not verified'),
                    ])
                    ->columns(2),

                Section::make('Timestamps')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->dateTime(),
                        
                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->dateTime(),
                    ])
                    ->columns(2),
            ]);
    }
}
