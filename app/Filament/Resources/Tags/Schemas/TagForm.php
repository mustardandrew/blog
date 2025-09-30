<?php

namespace App\Filament\Resources\Tags\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TagForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Tag Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (string $operation, $state, callable $set) {
                                if ($operation !== 'create') {
                                    return;
                                }
                                $set('slug', Str::slug($state));
                            }),

                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->rules(['alpha_dash'])
                            ->helperText('Used in URLs. Auto-generated from name if left empty.'),

                        Textarea::make('description')
                            ->maxLength(500)
                            ->rows(3)
                            ->helperText('Optional description of the tag.')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Settings')
                    ->schema([
                        ColorPicker::make('color')
                            ->label('Color')
                            ->default('#64748b')
                            ->helperText('Color used in the UI.'),

                        Toggle::make('is_featured')
                            ->label('Featured Tag')
                            ->default(false)
                            ->helperText('Featured tags are highlighted and shown prominently.'),

                        TextInput::make('usage_count')
                            ->label('Usage Count')
                            ->numeric()
                            ->default(0)
                            ->disabled()
                            ->dehydrated(false)
                            ->helperText('Automatically calculated based on post associations.'),
                    ]),
            ]);
    }
}
