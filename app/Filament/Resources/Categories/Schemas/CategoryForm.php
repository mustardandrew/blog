<?php

namespace App\Filament\Resources\Categories\Schemas;

use App\Models\Category;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Category Information')
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
                            ->maxLength(1000)
                            ->rows(3)
                            ->helperText('Optional description of the category.')
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Organization')
                    ->schema([
                        Select::make('parent_id')
                            ->label('Parent Category')
                            ->options(function (?Category $record) {
                                $query = Category::query()
                                    ->whereNull('parent_id')
                                    ->orWhere(function ($q) use ($record) {
                                        $q->whereNotNull('parent_id');
                                        if ($record) {
                                            $q->where('id', '!=', $record->id);
                                        }
                                    });

                                return $query->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->helperText('Leave empty to make this a root category.'),

                        TextInput::make('sort_order')
                            ->label('Sort Order')
                            ->numeric()
                            ->default(0)
                            ->helperText('Lower numbers appear first.'),

                        ColorPicker::make('color')
                            ->label('Color')
                            ->default('#6366f1')
                            ->helperText('Color used in the UI.'),

                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Only active categories are shown on the frontend.'),
                    ]),
            ]);
    }
}
