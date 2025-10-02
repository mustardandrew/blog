<?php

namespace App\Filament\Resources\Contacts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IconColumn::make('is_read')
                    ->label('')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedEnvelopeOpen)
                    ->falseIcon(Heroicon::OutlinedEnvelope)
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->weight('medium'),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copied')
                    ->color('primary'),
                TextColumn::make('subject')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= 50) {
                            return null;
                        }

                        return $state;
                    }),
                TextColumn::make('created_at')
                    ->label('Received')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->color('gray'),
                TextColumn::make('read_at')
                    ->label('Read')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->placeholder('Not read')
                    ->color('success')
                    ->toggleable(),
                TextColumn::make('ip_address')
                    ->label('IP')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('user_agent')
                    ->label('User Agent')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(50),
            ])
            ->filters([
                SelectFilter::make('is_read')
                    ->label('Status')
                    ->options([
                        true => 'Read',
                        false => 'Unread',
                    ])
                    ->default(false),
            ])
            ->recordActions([
                ViewAction::make()
                    ->iconButton(),
                EditAction::make()
                    ->iconButton(),
            ])
            ->defaultSort('created_at', 'desc')
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
