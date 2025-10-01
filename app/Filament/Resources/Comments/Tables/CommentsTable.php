<?php

namespace App\Filament\Resources\Comments\Tables;

use App\Models\Comment;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CommentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('post.title')
                    ->label('Post')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->tooltip(fn (Comment $record) => $record->post->title),

                TextColumn::make('author_display_name')
                    ->label('Author')
                    ->searchable(['author_name', 'user.name', 'author_email'])
                    ->sortable(),

                TextColumn::make('content')
                    ->label('Comment')
                    ->limit(50)
                    ->tooltip(fn (Comment $record) => $record->content)
                    ->wrap(),

                IconColumn::make('is_approved')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon(Heroicon::OutlinedCheckCircle)
                    ->falseIcon(Heroicon::OutlinedXCircle)
                    ->trueColor(Color::Green)
                    ->falseColor(Color::Red)
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->tooltip(fn (Comment $record) => $record->created_at->format('M j, Y g:i A')),

                TextColumn::make('replies_count')
                    ->label('Replies')
                    ->counts('replies')
                    ->badge()
                    ->color(Color::Gray),
            ])
            ->filters([
                TernaryFilter::make('is_approved')
                    ->label('Approval Status')
                    ->placeholder('All comments')
                    ->trueLabel('Approved')
                    ->falseLabel('Pending'),

                SelectFilter::make('post_id')
                    ->label('Post')
                    ->relationship('post', 'title')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('has_user')
                    ->label('Author Type')
                    ->placeholder('All authors')
                    ->trueLabel('Registered users')
                    ->falseLabel('Guest comments')
                    ->queries(
                        true: fn (Builder $query) => $query->whereNotNull('user_id'),
                        false: fn (Builder $query) => $query->whereNull('user_id'),
                    ),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    Action::make('approve')
                        ->icon('heroicon-o-check-circle')
                        ->color(Color::Green)
                        ->visible(fn (Comment $record) => ! $record->is_approved)
                        ->action(fn (Comment $record) => $record->update(['is_approved' => true]))
                        ->requiresConfirmation()
                        ->modalHeading('Approve Comment')
                        ->modalDescription('Are you sure you want to approve this comment?'),
                    Action::make('reject')
                        ->icon('heroicon-o-x-circle')
                        ->color(Color::Red)
                        ->visible(fn (Comment $record) => $record->is_approved)
                        ->action(fn (Comment $record) => $record->update(['is_approved' => false]))
                        ->requiresConfirmation()
                        ->modalHeading('Reject Comment')
                        ->modalDescription('Are you sure you want to reject this comment?'),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
