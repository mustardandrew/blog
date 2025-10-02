<?php

namespace App\Filament\Widgets;

use App\Models\Contact;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

class UnreadContactsWidget extends Widget
{
    protected static ?int $sort = 1;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 1;

    protected function getView(): string
    {
        return 'filament.widgets.unread-contacts-widget';
    }

    public function render(): View
    {
        return view($this->getView(), $this->getViewData());
    }

    public static function canView(): bool
    {
        // Only show when there are unread contacts
        return Contact::unread()->count() > 0;
    }

    protected function getViewData(): array
    {
        $unreadCount = Contact::unread()->count();
        $totalCount = Contact::count();
        $todayCount = Contact::whereDate('created_at', today())->count();
        $recentUnread = Contact::unread()->latest()->take(3)->get();

        return [
            'unreadCount' => $unreadCount,
            'totalCount' => $totalCount,
            'todayCount' => $todayCount,
            'recentUnread' => $recentUnread,
            'contactsIndexUrl' => route('filament.admin.resources.contacts.index'),
            'unreadContactsUrl' => route('filament.admin.resources.contacts.index', ['filters[is_read][value]' => false]),
            'editContactUrl' => fn ($contact) => route('filament.admin.resources.contacts.edit', ['record' => $contact]),
        ];
    }

    public function getPollingInterval(): ?string
    {
        return '30s'; // Refresh every 30 seconds to check for new messages
    }
}
