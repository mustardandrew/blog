<?php

namespace App\Filament\Resources\PageSeos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class PageSeosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('key')
                    ->label('Ключ')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('title')
                    ->label('SEO заголовок')
                    ->searchable()
                    ->limit(50),

                IconColumn::make('noindex')
                    ->label('Індексація')
                    ->boolean()
                    ->trueIcon('heroicon-o-x-mark')
                    ->falseIcon('heroicon-o-check')
                    ->trueColor('danger')
                    ->falseColor('success'),

                IconColumn::make('nofollow')
                    ->label('Переходи')
                    ->boolean()
                    ->trueIcon('heroicon-o-x-mark')
                    ->falseIcon('heroicon-o-check')
                    ->trueColor('danger')
                    ->falseColor('success'),

                TextColumn::make('created_at')
                    ->label('Створено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->label('Оновлено')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('noindex')
                    ->label('Індексація заборонена')
                    ->placeholder('Усі')
                    ->trueLabel('Заборонена')
                    ->falseLabel('Дозволена'),

                TernaryFilter::make('nofollow')
                    ->label('Переходи заборонені')
                    ->placeholder('Усі')
                    ->trueLabel('Заборонені')
                    ->falseLabel('Дозволені'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
