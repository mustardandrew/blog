<?php

namespace App\Filament\Resources\Newsletters\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsletterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Subscription Details')
                    ->schema([
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),

                        TextInput::make('name')
                            ->label('Subscriber Name')
                            ->maxLength(255),

                        Select::make('user_id')
                            ->label('Linked User')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable()
                            ->helperText('If linked to a registered user'),
                    ])
                    ->columns(2),

                Section::make('Status & Verification')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active Subscription')
                            ->default(true)
                            ->helperText('Whether this subscription is currently active'),

                        DateTimePicker::make('email_verified_at')
                            ->label('Email Verified At')
                            ->nullable()
                            ->helperText('When the email was verified'),

                        DateTimePicker::make('subscribed_at')
                            ->label('Subscribed At')
                            ->default(now())
                            ->required()
                            ->helperText('When the subscription was created'),

                        DateTimePicker::make('unsubscribed_at')
                            ->label('Unsubscribed At')
                            ->nullable()
                            ->helperText('When the user unsubscribed (if applicable)'),
                    ])
                    ->columns(2),
            ]);
    }
}
