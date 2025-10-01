<?php

namespace App\Filament\Resources\Newsletters\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class NewslettersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('email')
                    ->label('Email Address')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Medium)
                    ->copyable()
                    ->copyMessage('Email copied to clipboard!'),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('user.name')
                    ->label('Linked User')
                    ->searchable()
                    ->sortable()
                    ->placeholder('Guest')
                    ->badge()
                    ->color('success'),

                IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable(),

                IconColumn::make('email_verified_at')
                    ->label('Verified')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->falseIcon('heroicon-o-shield-exclamation')
                    ->trueColor('success')
                    ->falseColor('warning')
                    ->getStateUsing(fn ($record) => ! is_null($record->email_verified_at))
                    ->sortable(),

                TextColumn::make('subscribed_at')
                    ->label('Subscribed')
                    ->dateTime('M j, Y g:i A')
                    ->sortable()
                    ->since()
                    ->tooltip(fn ($record) => $record->subscribed_at->format('F j, Y \a\t g:i A')),

                TextColumn::make('unsubscribed_at')
                    ->label('Unsubscribed')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->placeholder('—')
                    ->color('danger'),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M j, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Active Status')
                    ->trueLabel('Active subscriptions only')
                    ->falseLabel('Inactive subscriptions only')
                    ->native(false),

                TernaryFilter::make('email_verified_at')
                    ->label('Email Verification')
                    ->trueLabel('Verified emails only')
                    ->falseLabel('Unverified emails only')
                    ->queries(
                        true: fn ($query) => $query->whereNotNull('email_verified_at'),
                        false: fn ($query) => $query->whereNull('email_verified_at'),
                    )
                    ->native(false),

                SelectFilter::make('user_id')
                    ->label('User Type')
                    ->options([
                        'guest' => 'Guest Subscriptions',
                        'user' => 'User Subscriptions',
                    ])
                    ->query(function ($query, array $data) {
                        if ($data['value'] === 'guest') {
                            return $query->whereNull('user_id');
                        } elseif ($data['value'] === 'user') {
                            return $query->whereNotNull('user_id');
                        }
                    })
                    ->native(false),
            ])
            ->recordActions([
                ViewAction::make()
                    ->color('info'),
                EditAction::make()
                    ->color('warning'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    \Filament\Actions\BulkAction::make('activate')
                        ->label('Activate Selected')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => true]);
                            });
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Activate Newsletter Subscriptions')
                        ->modalDescription('Are you sure you want to activate the selected newsletter subscriptions?')
                        ->modalSubmitActionLabel('Activate'),

                    \Filament\Actions\BulkAction::make('deactivate')
                        ->label('Deactivate Selected')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                $record->update(['is_active' => false]);
                            });
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Deactivate Newsletter Subscriptions')
                        ->modalDescription('Are you sure you want to deactivate the selected newsletter subscriptions?')
                        ->modalSubmitActionLabel('Deactivate'),

                    \Filament\Actions\BulkAction::make('verify')
                        ->label('Mark as Verified')
                        ->icon('heroicon-o-shield-check')
                        ->color('warning')
                        ->action(function ($records) {
                            $records->each(function ($record) {
                                if (is_null($record->email_verified_at)) {
                                    $record->markAsVerified();
                                }
                            });
                        })
                        ->requiresConfirmation()
                        ->modalHeading('Verify Email Addresses')
                        ->modalDescription('Are you sure you want to mark the selected email addresses as verified?')
                        ->modalSubmitActionLabel('Verify'),

                    DeleteBulkAction::make()
                        ->requiresConfirmation(),
                ]),
            ])
            ->defaultSort('subscribed_at', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100]);
    }
}
