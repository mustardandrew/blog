<style>
/* Стилі для кастомного віджета немодерованих коментарів */
.unmoderated-comments-widget {
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
    .unmoderated-comments-widget {
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

.dark .unmoderated-comments-widget {
    --bg-primary: #1f2937;
    --bg-card: #374151;
    --text-primary: #f9fafb;
    --text-secondary: #9ca3af;
    --text-tertiary: #d1d5db;
    --border-color: #374151;
    --warning-bg: #451a03;
    --shadow: 0 1px 3px rgba(0,0,0,0.3);
}

.unmoderated-comments-widget .widget-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1rem;
}

.unmoderated-comments-widget .widget-header-left {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.unmoderated-comments-widget .widget-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 2rem;
    height: 2rem;
    background-color: var(--warning-bg);
    border-radius: 0.5rem;
}

.unmoderated-comments-widget .widget-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary);
    margin: 0;
}

.unmoderated-comments-widget .widget-subtitle {
    font-size: 0.875rem;
    color: var(--text-secondary);
    margin: 0;
}

.unmoderated-comments-widget .widget-header-right {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.unmoderated-comments-widget .stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1rem;
    margin-bottom: 1rem;
}

.unmoderated-comments-widget .stat-card {
    padding: 0.75rem;
    background: var(--bg-card);
    border-radius: 0.5rem;
    box-shadow: var(--shadow);
    text-align: center;
    border: 1px solid var(--border-color);
}

.unmoderated-comments-widget .stat-card.warning {
    border-left: 4px solid var(--warning-color);
}

.unmoderated-comments-widget .stat-card.primary {
    border-left: 4px solid var(--primary-color);
}

.unmoderated-comments-widget .stat-card.success {
    border-left: 4px solid var(--success-color);
}

.unmoderated-comments-widget .stat-card.gray {
    border-left: 4px solid var(--gray-color);
}

.unmoderated-comments-widget .stat-number {
    font-size: 1.125rem;
    font-weight: 600;
    color: var(--text-primary);
}

.unmoderated-comments-widget .stat-number.muted {
    color: var(--text-secondary);
}

.unmoderated-comments-widget .stat-label {
    font-size: 0.75rem;
    color: var(--text-secondary);
}

.unmoderated-comments-widget .recent-section {
    border-top: 1px solid var(--border-color);
    padding-top: 1rem;
}

.unmoderated-comments-widget .recent-header {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-primary);
    margin-bottom: 0.75rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.unmoderated-comments-widget .comments-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.unmoderated-comments-widget .comment-card {
    padding: 0.75rem;
    background: var(--bg-card);
    border-radius: 0.5rem;
    box-shadow: var(--shadow);
    transition: background-color 0.2s;
    border: 1px solid var(--border-color);
}

.unmoderated-comments-widget .comment-card:hover {
    background: var(--bg-primary);
}

.unmoderated-comments-widget .comment-content {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
}

.unmoderated-comments-widget .comment-details {
    flex: 1;
    min-width: 0;
}

.unmoderated-comments-widget .comment-body {
    margin-top: 0.25rem;
    display: flex;
}

.unmoderated-comments-widget .comment-body > div:first-child {
    flex: 1;
}

.unmoderated-comments-widget .comment-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    padding-left: 0.5rem;
    opacity: 0;
    transition: opacity 0.2s;
}

.unmoderated-comments-widget .comment-card:hover .comment-actions {
    opacity: 1;
}

.unmoderated-comments-widget .comment-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.25rem;
}

.unmoderated-comments-widget .comment-author {
    font-size: 0.875rem;
    font-weight: 500;
    color: var(--text-primary);
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    margin: 0;
}

.unmoderated-comments-widget .comment-time {
    font-size: 0.75rem;
    color: var(--text-secondary);
    margin: 0;
}

.unmoderated-comments-widget .comment-post {
    font-size: 0.875rem;
    color: var(--text-tertiary);
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    margin: 0;
}

.unmoderated-comments-widget .comment-preview {
    font-size: 0.75rem;
    color: var(--text-secondary);
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    margin: 0;
}

.unmoderated-comments-widget .view-all-section {
    margin-top: 0.75rem;
    text-align: center;
}

/* Світла тема (explicit overrides) */
html:not(.dark) .unmoderated-comments-widget .stat-card {
    background: #ffffff;
    border: 1px solid #d1d5db;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12);
}

html:not(.dark) .unmoderated-comments-widget .stat-card.warning {
    border-left: 4px solid #f59e0b;
}

html:not(.dark) .unmoderated-comments-widget .stat-card.primary {
    border-left: 4px solid #3b82f6;
}

html:not(.dark) .unmoderated-comments-widget .stat-card.success {
    border-left: 4px solid #22c55e;
}

html:not(.dark) .unmoderated-comments-widget .stat-card.gray {
    border-left: 4px solid #9ca3af;
}

html:not(.dark) .unmoderated-comments-widget .comment-card {
    background: #ffffff;
    border: 1px solid #d1d5db;
    box-shadow: 0 1px 3px rgba(0,0,0,0.12);
}

html:not(.dark) .unmoderated-comments-widget .comment-card:hover {
    background: #f8fafc;
    box-shadow: 0 2px 6px rgba(0,0,0,0.15);
}

html:not(.dark) .unmoderated-comments-widget .widget-title {
    color: #111827;
}

html:not(.dark) .unmoderated-comments-widget .widget-subtitle {
    color: #374151;
}

html:not(.dark) .unmoderated-comments-widget .recent-header {
    color: #111827;
}

html:not(.dark) .unmoderated-comments-widget .stat-number {
    color: #111827;
}

html:not(.dark) .unmoderated-comments-widget .stat-label {
    color: #374151;
}

html:not(.dark) .unmoderated-comments-widget .comment-author {
    color: #111827;
}

html:not(.dark) .unmoderated-comments-widget .comment-post {
    color: #374151;
}

html:not(.dark) .unmoderated-comments-widget .comment-preview {
    color: #6b7280;
}

html:not(.dark) .unmoderated-comments-widget .comment-time {
    color: #6b7280;
}

/* Іконка для світлої теми */
html:not(.dark) .unmoderated-comments-widget .widget-icon {
    background-color: #fef3c7;
}

html:not(.dark) .unmoderated-comments-widget .recent-header-icon {
    color: #6b7280;
}
</style>

<x-filament::widget>
    <x-filament::card>
        <div class="unmoderated-comments-widget">
            <!-- Header -->
            <div class="widget-header">
                <div class="widget-header-left">
                    <div class="widget-icon">
                        <x-heroicon-o-chat-bubble-left-ellipsis style="width: 1.25rem; height: 1.25rem; color: #d97706;" />
                    </div>
                    <div>
                        <h3 class="widget-title">
                            Pending Comments
                        </h3>
                        <p class="widget-subtitle">
                            {{ $unapprovedCount }} {{ $unapprovedCount === 1 ? 'comment' : 'comments' }} awaiting moderation
                        </p>
                    </div>
                </div>
                <div class="widget-header-right">
                    <x-filament::badge color="warning" size="sm">
                        {{ $unapprovedCount }}
                    </x-filament::badge>
                    <x-filament::button
                        color="warning"
                        size="sm"
                        :href="$unapprovedCommentsUrl"
                        tag="a"
                    >
                        View All
                    </x-filament::button>
                </div>
            </div>

            <!-- Statistics Row -->
            <div class="stats-grid">
                <div class="stat-card warning">
                    <div class="stat-number">{{ $unapprovedCount }}</div>
                    <div class="stat-label">Pending</div>
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

            <!-- Recent Comments -->
            @if($recentUnapproved->isNotEmpty())
            <div class="recent-section">
                <h4 class="recent-header">
                    <x-heroicon-o-clock class="recent-header-icon" style="width: 1rem; height: 1rem;" />
                    Recent Comments
                </h4>
                <div class="comments-list">
                    @foreach($recentUnapproved as $comment)
                    <div class="comment-card">
                        <div class="comment-content">
                            <div class="comment-details">
                                <div class="comment-header">
                                    <p class="comment-author">
                                        {{ $comment->author_display_name }}
                                    </p>
                                    <p class="comment-time">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </p>
                                </div>
                                <div class="comment-body">
                                    <div>
                                        <p class="comment-post">
                                            On: {{ Str::limit($comment->post->title ?? 'Unknown Post', 40) }}
                                        </p>
                                        <p class="comment-preview">
                                            {{ Str::limit($comment->content, 65) }}
                                        </p>
                                    </div>
                                    <div class="comment-actions">
                                        <x-filament::button
                                            color="gray"
                                            size="xs"
                                            :href="$editCommentUrl($comment)"
                                            tag="a"
                                            icon="heroicon-o-pencil"
                                            :tooltip="'Moderate comment by ' . $comment->author_display_name"
                                        >
                                            Moderate
                                        </x-filament::button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                @if($recentUnapproved->count() > 0)
                <div class="view-all-section">
                    <x-filament::link
                        :href="$unapprovedCommentsUrl"
                        color="warning"
                        size="sm"
                    >
                        View all {{ $unapprovedCount }} pending comments →
                    </x-filament::link>
                </div>
                @endif
            </div>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget>