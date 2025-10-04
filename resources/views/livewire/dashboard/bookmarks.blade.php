<div>
    <!-- Stats -->
    <div class="mb-6">
        <flux:text class="text-gray-600 dark:text-gray-400">
            {{ $bookmarks->total() }} {{ \Illuminate\Support\Str::plural('збережена стаття', $bookmarks->total()) }}
        </flux:text>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6">
            <flux:callout variant="success">{{ session('message') }}</flux:callout>
        </div>
    @endif

    <!-- Search -->
    <div class="mb-6">
        <flux:field>
            <flux:label>Пошук</flux:label>
            <flux:input 
                wire:model.live.debounce.300ms="search"
                placeholder="Пошук за назвою або описом..."
                type="search"
            />
        </flux:field>
    </div>

    <!-- Content -->
    @if($bookmarks->count() > 0)
        <div class="space-y-4">
            @foreach($bookmarks as $post)
                <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
                    <h3 class="font-bold text-lg mb-2">
                        <a href="{{ route('posts.show', $post->slug) }}" class="hover:text-blue-600">
                            {{ $post->title }}
                        </a>
                    </h3>
                    
                    @if($post->excerpt)
                        <p class="text-zinc-600 dark:text-zinc-400 mb-4">{{ $post->excerpt }}</p>
                    @endif
                    
                    <div class="flex justify-between items-center">
                        <span class="text-sm text-zinc-500">{{ $post->published_at?->format('d.m.Y') }}</span>
                        <flux:button 
                            variant="danger"
                            size="sm"
                            wire:click="removeBookmark({{ $post->id }})"
                            wire:confirm="Видалити закладку?"
                        >
                            Видалити
                        </flux:button>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6">{{ $bookmarks->links() }}</div>
    @else
        <div class="text-center py-12">
            <flux:text class="text-zinc-600 dark:text-zinc-400">
                @if($search)
                    Нічого не знайдено за запитом "{{ $search }}"
                @else
                    У вас поки немає закладок
                @endif
            </flux:text>
        </div>
    @endif
</div>
