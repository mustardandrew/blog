<?php

namespace App\Filament\Resources\PageSeos;

use App\Enums\NavigationGroup;
use App\Filament\Resources\PageSeos\Pages\CreatePageSeo;
use App\Filament\Resources\PageSeos\Pages\EditPageSeo;
use App\Filament\Resources\PageSeos\Pages\ListPageSeos;
use App\Filament\Resources\PageSeos\Tables\PageSeosTable;
use App\Models\PageSeo;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PageSeoResource extends Resource
{
    protected static ?string $model = PageSeo::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static ?string $navigationLabel = 'SEO Сторінок';

    protected static ?string $modelLabel = 'SEO сторінки';

    protected static ?string $pluralModelLabel = 'SEO сторінок';

    protected static string|\UnitEnum|null $navigationGroup = NavigationGroup::Settings;

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('key')
                    ->label('Ключ сторінки')
                    ->helperText('Унікальний ключ для ідентифікації сторінки (наприклад: home, blog, contact)')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),

                TextInput::make('title')
                    ->label('SEO заголовок')
                    ->helperText('Заголовок, який відображається в результатах пошуку')
                    ->maxLength(255),

                Textarea::make('meta_description')
                    ->label('META опис')
                    ->helperText('Опис сторінки для пошукових систем (150-160 символів)')
                    ->maxLength(160)
                    ->rows(3),

                Textarea::make('keywords')
                    ->label('Ключові слова')
                    ->helperText('Ключові слова через кому')
                    ->rows(2),

                Toggle::make('noindex')
                    ->label('Заборонити індексацію')
                    ->helperText('Заборонити пошуковим системам індексувати цю сторінку')
                    ->default(false),

                Toggle::make('nofollow')
                    ->label('Заборонити переходи')
                    ->helperText('Заборонити пошуковим системам переходити по посиланнях на цій сторінці')
                    ->default(false),

                Textarea::make('additional_meta')
                    ->label('Додаткові META теги (JSON)')
                    ->helperText('Додаткові META теги у форматі JSON: {"property": "value"}')
                    ->rows(4),
            ]);
    }

    public static function table(Table $table): Table
    {
        return PageSeosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPageSeos::route('/'),
            'create' => CreatePageSeo::route('/create'),
            'edit' => EditPageSeo::route('/{record}/edit'),
        ];
    }
}
