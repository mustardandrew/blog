<?php

namespace App\Filament\Widgets;

use App\Models\Comment;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class CommentStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 3;

    protected static bool $isLazy = false;

    public static function canView(): bool
    {
        // Show if there are any comments
        return Comment::count() > 0;
    }

    protected function getStats(): array
    {
        $pendingCount = Comment::where('is_approved', false)->count();
        $approvedCount = Comment::approved()->count();
        $todayCount = Comment::whereDate('created_at', today())->count();

        $stats = [];

        // Show pending comments with warning if any exist
        if ($pendingCount > 0) {
            $stats[] = Stat::make('⏳ Pending Comments', $pendingCount)
                ->description('Comments awaiting approval')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning')
                ->url(route('filament.admin.resources.comments.index', ['tableFilters[is_approved][value]' => false]))
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-orange-50 dark:hover:bg-orange-950/20 border-l-4 border-orange-400',
                ]);
        }

        // Show approved comments
        $stats[] = Stat::make('✅ Approved Comments', $approvedCount)
            ->description('Active comments on posts')
            ->descriptionIcon('heroicon-o-check-circle')
            ->color('success')
            ->url(route('filament.admin.resources.comments.index', ['tableFilters[is_approved][value]' => true]))
            ->extraAttributes([
                'class' => 'border-l-4 border-green-400',
            ]);

        // Show today's comments if any
        if ($todayCount > 0) {
            $stats[] = Stat::make('📅 Today\'s Comments', $todayCount)
                ->description('Comments posted today')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('info')
                ->extraAttributes([
                    'class' => 'border-l-4 border-blue-400',
                ]);
        }

        return $stats;
    }

    public function getPollingInterval(): ?string
    {
        return '45s'; // Refresh every 45 seconds
    }
}
