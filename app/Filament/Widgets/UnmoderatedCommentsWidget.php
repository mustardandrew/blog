<?php

namespace App\Filament\Widgets;

use App\Models\Comment;
use Filament\Widgets\Widget;
use Illuminate\Contracts\View\View;

class UnmoderatedCommentsWidget extends Widget
{
    protected static ?int $sort = 2;

    protected static bool $isLazy = false;

    protected int|string|array $columnSpan = 'full';

    protected function getView(): string
    {
        return 'filament.widgets.unmoderated-comments-widget';
    }

    public function render(): View
    {
        return view($this->getView(), $this->getViewData());
    }

    public static function canView(): bool
    {
        // Only show when there are unapproved comments
        return Comment::where('is_approved', false)->count() > 0;
    }

    protected function getViewData(): array
    {
        $unapprovedCount = Comment::where('is_approved', false)->count();
        $totalCount = Comment::count();
        $todayCount = Comment::whereDate('created_at', today())->count();
        $recentUnapproved = Comment::where('is_approved', false)
            ->with(['post', 'user'])
            ->latest()
            ->take(3)
            ->get();

        return [
            'unapprovedCount' => $unapprovedCount,
            'totalCount' => $totalCount,
            'todayCount' => $todayCount,
            'recentUnapproved' => $recentUnapproved,
            'commentsIndexUrl' => route('filament.admin.resources.comments.index'),
            'unapprovedCommentsUrl' => route('filament.admin.resources.comments.index', ['tableFilters[is_approved][value]' => false]),
            'editCommentUrl' => fn ($comment) => route('filament.admin.resources.comments.edit', ['record' => $comment]),
        ];
    }

    public function getPollingInterval(): ?string
    {
        return '30s'; // Refresh every 30 seconds to check for new comments
    }
}
