<?php

namespace App\Filament\Widgets;

use App\Models\Comment;
use Filament\Actions\Action;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class RecentCommentsWidget extends TableWidget
{
    protected static ?int $sort = 2;

    protected int|string|array $columnSpan = 'full';

    protected static ?string $heading = 'Recent Comments';

    protected static ?string $maxHeight = '300px';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Comment::with(['post', 'user'])
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                IconColumn::make('status')
                    ->label('')
                    ->getStateUsing(fn (Comment $record) => $record->is_approved ? 'approved' : 'pending')
                    ->icon(fn (string $state) => match ($state) {
                        'approved' => Heroicon::OutlinedCheckCircle,
                        'pending' => Heroicon::OutlinedClock,
                        default => Heroicon::OutlinedQuestionMarkCircle,
                    })
                    ->color(fn (string $state) => match ($state) {
                        'approved' => 'success',
                        'pending' => 'warning',
                        default => 'gray',
                    })
                    ->tooltip(fn (string $state) => match ($state) {
                        'approved' => 'Approved comment',
                        'pending' => 'Pending approval',
                        default => 'Unknown status',
                    }),

                TextColumn::make('user.name')
                    ->label('Author')
                    ->formatStateUsing(fn (?string $state, Comment $record) => $state ?: $record->author_name ?: 'Anonymous')
                    ->searchable(['name', 'author_name'])
                    ->sortable()
                    ->weight('medium'),

                TextColumn::make('content')
                    ->label('Comment')
                    ->limit(100)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= 100) {
                            return null;
                        }

                        return $state;
                    })
                    ->wrap(),

                TextColumn::make('post.title')
                    ->label('Post')
                    ->limit(40)
                    ->tooltip(function (TextColumn $column): ?string {
                        $state = $column->getState();

                        if (strlen($state) <= 40) {
                            return null;
                        }

                        return $state;
                    })
                    ->url(fn (Comment $record) => route('posts.show', $record->post))
                    ->openUrlInNewTab()
                    ->color('primary'),

                TextColumn::make('created_at')
                    ->label('Posted')
                    ->dateTime('M j, g:i A')
                    ->sortable()
                    ->color('gray')
                    ->since()
                    ->tooltip(fn (Comment $record) => $record->created_at->format('F j, Y g:i:s A')),
            ])
            ->headerActions([
                Action::make('view_all')
                    ->label('View All Comments')
                    ->icon(Heroicon::OutlinedChatBubbleLeftRight)
                    ->url(route('filament.admin.resources.comments.index'))
                    ->color('primary'),
            ])
            ->defaultSort('created_at', 'desc')
            ->striped()
            ->paginated(false);
    }

    public static function canView(): bool
    {
        // Show if there are any comments
        return Comment::count() > 0;
    }

    public function getPollingInterval(): ?string
    {
        return '60s'; // Refresh every minute to check for new comments
    }
}
