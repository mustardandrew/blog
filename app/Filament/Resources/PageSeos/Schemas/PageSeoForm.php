<?php

namespace App\Filament\Resources\PageSeos\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset as SchemaFieldset;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class PageSeoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(2)
                    ->schema([
                        TextInput::make('key')
                            ->label('Ключ сторінки')
                            ->helperText('Унікальний ключ для ідентифікації сторінки (наприклад: home, blog, contact)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(1),

                        TextInput::make('title')
                            ->label('SEO заголовок')
                            ->helperText('Заголовок, який відображається в результатах пошуку')
                            ->maxLength(255)
                            ->columnSpan(1),
                    ]),

                Textarea::make('meta_description')
                    ->label('META опис')
                    ->helperText('Опис сторінки для пошукових систем (150-160 символів)')
                    ->maxLength(160)
                    ->rows(3),

                Textarea::make('keywords')
                    ->label('Ключові слова')
                    ->helperText('Ключові слова через кому')
                    ->rows(2),

                SchemaFieldset::make('Налаштування індексації')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Toggle::make('noindex')
                                    ->label('Заборонити індексацію')
                                    ->helperText('Заборонити пошуковим системам індексувати цю сторінку')
                                    ->default(false),

                                Toggle::make('nofollow')
                                    ->label('Заборонити переходи')
                                    ->helperText('Заборонити пошуковим системам переходити по посиланнях на цій сторінці')
                                    ->default(false),
                            ]),
                    ]),

                Textarea::make('additional_meta')
                    ->label('Додаткові META теги (JSON)')
                    ->helperText('Додаткові META теги у форматі JSON: {"property": "value"}')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
