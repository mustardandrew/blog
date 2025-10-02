<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Contact Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->maxLength(255),
                        TextInput::make('subject')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('message')
                            ->required()
                            ->maxLength(5000)
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Technical Information')
                    ->schema([
                        TextInput::make('ip_address')
                            ->label('IP Address')
                            ->disabled(),
                        TextInput::make('user_agent')
                            ->label('User Agent')
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->collapsed()
                    ->columns(2),

                Section::make('Status')
                    ->schema([
                        Toggle::make('is_read')
                            ->label('Mark as Read')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $set('read_at', now());
                                } else {
                                    $set('read_at', null);
                                }
                            }),
                        DateTimePicker::make('read_at')
                            ->label('Read At')
                            ->hidden(fn (callable $get) => ! $get('is_read')),
                    ])
                    ->columns(2),
            ]);
    }
}
