<style>
/* Стилі для кастомного віджета непрочитаних контактів */
.unread-contacts-widget {
    --bg-primary: #ffffff;
    --bg-card: #f9fafb;
    --text-primary: #111827;
    --text-secondary: #6b7280;
    --text-tertiary: #4b5563;
    --border-color: #e5e7eb;
    --warning-color: #f59e0b;
    --primary-color: #3b82f6;
    --success-color: #22c55e;
    --gray-color: #9ca3af;
    --warning-bg: #fef3c7;
    --shadow: 0 1px 3px rgba(0,0,0,0.1);
}

/* Темна тема */
@media (prefers-color-scheme: dark) {
    .unread-contacts-widget {
        --bg-primary: #1f2937;
        --bg-card: #374151;
        --text-primary: #f9fafb;
        --text-secondary: #9ca3af;
        --text-tertiary: #d1d5db;
        --border-color: #374151;
        --warning-bg: #451a03;
        --shadow: 0 1px 3px rgba(0,0,0,0.3);
    }
}

.dark .unread-contacts-widget {
    --bg-primary: #1f2937;
    --bg-card: #374151;
    --text-primary: #f9fafb;
    --text-secondary: #9ca3af;
    --text-tertiary: #d1d5db;
    --border-color: #374151;
    --warning-bg: #451a03;
    --shadow: 0 1px 3px rgba(0,0,0,0.3);
}

.unread-contacts-widget .widget-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.unread-contacts-widget .widget-header-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.unread-contacts-widget .widget-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    background-color: var(--warning-bg);
    border-radius: 0.5rem;
}

.unread-contacts-widget .widget-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.unread-contacts-widget .widget-subtitle {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0;
}

.unread-contacts-widget .widget-header-right {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.unread-contacts-widget .stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1rem;
}

.unread-contacts-widget .stat-card {
    padding: 0.75rem;
    background: var(--bg-card);
    border-radius: 0.5rem;
    box-shadow: var(--shadow);
    text-align: center;
    border: 1px solid var(--border-color);
}

.unread-contacts-widget .stat-card.warning {
    border-left: 4px solid var(--warning-color);
}

.unread-contacts-widget .stat-card.primary {
    border-left: 4px solid var(--primary-color);
}

.unread-contacts-widget .stat-card.success {
    border-left: 4px solid var(--success-color);
}

.unread-contacts-widget .stat-card.gray {
    border-left: 4px solid var(--gray-color);
}

.unread-contacts-widget .stat-number {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
}

.unread-contacts-widget .stat-number.muted {
    color: var(--text-secondary);
}

.unread-contacts-widget .stat-label {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.unread-contacts-widget .recent-section {
    border-top: 1px solid var(--border-color);
    padding-top: 1rem;
}

.unread-contacts-widget .recent-header {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.unread-contacts-widget .messages-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.unread-contacts-widget .message-card {
    padding: 0.75rem;
    background: var(--bg-card);
    border-radius: 0.5rem;
    box-shadow: var(--shadow);
    transition: background-color 0.2s;
    border: 1px solid var(--border-color);
}

.unread-contacts-widget .message-card:hover {
    background: var(--bg-primary);
}

.unread-contacts-widget .message-content {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.unread-contacts-widget .message-details {
    flex: 1;
    min-width: 0;
}

.unread-contacts-widget .message-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.25rem;
}

.unread-contacts-widget .message-name {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-primary);
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    margin: 0;
}

.unread-contacts-widget .message-time {
    font-size: 0.75rem;
    color: var(--text-secondary);
    margin: 0;
}

.unread-contacts-widget .message-subject {
    font-size: 0.875rem;
    color: var(--text-tertiary);
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    margin: 0;
}

.unread-contacts-widget .message-preview {
    font-size: 0.75rem;
    color: var(--text-secondary);
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    margin: 0;
}

.unread-contacts-widget .view-all-section {
    margin-top: 0.75rem;
    text-align: center;
}

/* Світла тема (explicit overrides) */
html:not(.dark) .unread-contacts-widget .stat-card {
    background: #ffffff;
    border: 1px solid #d1d5db;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12);
}

html:not(.dark) .unread-contacts-widget .message-card {
    background: #ffffff;
    border: 1px solid #d1d5db;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12);
}

html:not(.dark) .unread-contacts-widget .message-card:hover {
    background: #f8fafc;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

html:not(.dark) .unread-contacts-widget .widget-title {
    color: #111827;
}

html:not(.dark) .unread-contacts-widget .widget-subtitle {
    color: #374151;
}

html:not(.dark) .unread-contacts-widget .recent-header {
    color: #111827;
}

html:not(.dark) .unread-contacts-widget .stat-number {
    color: #111827;
}

html:not(.dark) .unread-contacts-widget .stat-label {
    color: #374151;
}

html:not(.dark) .unread-contacts-widget .message-name {
    color: #111827;
}

html:not(.dark) .unread-contacts-widget .message-subject {
    color: #374151;
}

html:not(.dark) .unread-contacts-widget .message-preview {
    color: #6b7280;
}

html:not(.dark) .unread-contacts-widget .message-time {
    color: #6b7280;
}

/* Іконка для світлої теми */
html:not(.dark) .unread-contacts-widget .widget-icon {
    background-color: #fef3c7;
}

html:not(.dark) .unread-contacts-widget .recent-header-icon {
    color: #6b7280;
}
</style>

<x-filament::widget>
    <x-filament::card>
        <div class="unread-contacts-widget">
            <!-- Header -->
            <div class="widget-header">
                <div class="widget-header-left">
                    <div class="widget-icon">
                        <x-heroicon-o-envelope style="width: 1.25rem; height: 1.25rem; color: #d97706;" />
                    </div>
                    <div>
                        <h3 class="widget-title">
                            Unread Messages
                        </h3>
                        <p class="widget-subtitle">
                            {{ $unreadCount }} {{ $unreadCount === 1 ? 'new message' : 'new messages' }} awaiting response
                        </p>
                    </div>
                </div>
                <div class="widget-header-right">
                    <x-filament::badge color="warning" size="sm">
                        {{ $unreadCount }}
                    </x-filament::badge>
                    <x-filament::button
                        color="warning"
                        size="sm"
                        :href="$unreadContactsUrl"
                        tag="a"
                    >
                        View All
                    </x-filament::button>
                </div>
            </div>

            <!-- Statistics Row -->
            <div class="stats-grid">
                <div class="stat-card warning">
                    <div class="stat-number">{{ $unreadCount }}</div>
                    <div class="stat-label">Unread</div>
                </div>
                
                <div class="stat-card primary">
                    <div class="stat-number">{{ $totalCount }}</div>
                    <div class="stat-label">Total</div>
                </div>
                
                <div class="stat-card {{ $todayCount > 0 ? 'success' : 'gray' }}">
                    <div class="stat-number {{ $todayCount == 0 ? 'muted' : '' }}">
                        {{ $todayCount }}
                    </div>
                    <div class="stat-label">Today</div>
                </div>
            </div>

            <!-- Recent Messages -->
            @if($recentUnread->isNotEmpty())
            <div class="recent-section">
                <h4 class="recent-header">
                    <x-heroicon-o-clock class="recent-header-icon" style="width: 1rem; height: 1rem;" />
                    Recent Messages
                </h4>
                <div class="messages-list">
                    @foreach($recentUnread as $contact)
                    <div class="message-card">
                        <div class="message-content">
                            <div class="message-details">
                                <div class="message-header">
                                    <p class="message-name">
                                        {{ $contact->name }}
                                    </p>
                                    <p class="message-time">
                                        {{ $contact->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <p class="message-subject">
                                    {{ Str::limit($contact->subject, 50) }}
                                </p>
                                <p class="message-preview">
                                    {{ Str::limit($contact->message, 80) }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($recentUnread->count() >= 5)
                <div class="view-all-section">
                    <x-filament::link
                        :href="$unreadContactsUrl"
                        color="warning"
                        size="sm"
                    >
                        View all {{ $unreadCount }} unread messages →
                    </x-filament::link>
                </div>
                @endif
            </div>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget>