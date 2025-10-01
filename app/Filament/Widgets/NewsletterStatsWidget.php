<?php

namespace App\Filament\Widgets;

use App\Models\Newsletter;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Carbon;

class NewsletterStatsWidget extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $totalSubscribers = Newsletter::count();
        $activeSubscribers = Newsletter::active()->count();
        $verifiedSubscribers = Newsletter::verified()->count();
        $newThisMonth = Newsletter::where('subscribed_at', '>=', Carbon::now()->startOfMonth())->count();
        $previousMonthSubscribers = Newsletter::where('subscribed_at', '>=', Carbon::now()->subMonth()->startOfMonth())
            ->where('subscribed_at', '<', Carbon::now()->startOfMonth())
            ->count();

        $monthlyGrowth = $previousMonthSubscribers > 0
            ? round((($newThisMonth - $previousMonthSubscribers) / $previousMonthSubscribers) * 100, 1)
            : ($newThisMonth > 0 ? 100 : 0);

        return [
            Stat::make('Total Subscribers', $totalSubscribers)
                ->description('All newsletter subscriptions')
                ->descriptionIcon('heroicon-m-users')
                ->color('primary'),

            Stat::make('Active Subscribers', $activeSubscribers)
                ->description($activeSubscribers.' of '.$totalSubscribers.' active')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Verified Emails', $verifiedSubscribers)
                ->description($verifiedSubscribers.' of '.$totalSubscribers.' verified')
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('warning'),

            Stat::make('New This Month', $newThisMonth)
                ->description($monthlyGrowth >= 0 ? "+{$monthlyGrowth}% from last month" : "{$monthlyGrowth}% from last month")
                ->descriptionIcon($monthlyGrowth >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($monthlyGrowth >= 0 ? 'success' : 'danger'),
        ];
    }

    protected function getColumns(): int
    {
        return 4;
    }
}
