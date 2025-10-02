<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UnreadContactsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    public static function canView(): bool
    {
        // Only show when there are unread contacts
        return Contact::unread()->count() > 0;
    }

    protected function getStats(): array
    {
        $unreadCount = Contact::unread()->count();
        $totalCount = Contact::count();
        $todayCount = Contact::whereDate('created_at', today())->count();
        $recentUnread = Contact::unread()->latest()->take(3)->get();

        $stats = [
            Stat::make('📧 Unread Messages', $unreadCount)
                ->description($unreadCount === 1 ? 'New contact message awaiting response' : 'New contact messages awaiting response')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('warning')
                ->extraAttributes([
                    'class' => 'cursor-pointer hover:bg-orange-50 dark:hover:bg-orange-950/20 transition-colors border-l-4 border-orange-400',
                ])
                ->url(route('filament.admin.resources.contacts.index', ['tableFilters[is_read][value]' => false])),
        ];

        // Add recent messages info if there are any
        if ($recentUnread->isNotEmpty()) {
            $recentMessages = $recentUnread->map(function ($contact) {
                return "• {$contact->name}: ".\Str::limit($contact->subject, 40);
            })->implode("\n");

            $stats[] = Stat::make('Recent Messages', $recentUnread->count())
                ->description($recentMessages)
                ->descriptionIcon('heroicon-o-clock')
                ->color('info')
                ->extraAttributes([
                    'class' => 'border-l-4 border-blue-400',
                ]);
        }

        // Show today's stats if there are any
        if ($todayCount > 0) {
            $stats[] = Stat::make('Today\'s Messages', $todayCount)
                ->description('Messages received today')
                ->descriptionIcon('heroicon-o-calendar-days')
                ->color('success')
                ->extraAttributes([
                    'class' => 'border-l-4 border-green-400',
                ]);
        }

        return $stats;
    }

    public function getPollingInterval(): ?string
    {
        return '30s'; // Refresh every 30 seconds to check for new messages
    }
}
