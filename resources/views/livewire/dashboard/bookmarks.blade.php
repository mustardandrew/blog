<div>
    <!-- Header with Stats -->
    <div class="mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div>
                <flux:heading size="lg" class="mb-3">Мої закладки</flux:heading>
                <div class="grid grid-cols-3 gap-4 text-center lg:text-left">
                    <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-3">
                        <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $stats['total'] }}</div>
                        <div class="text-sm text-blue-600/70 dark:text-blue-400/70">Всього</div>
                    </div>
                    <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-3">
                        <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $stats['recent'] }}</div>
                        <div class="text-sm text-green-600/70 dark:text-green-400/70">За тиждень</div>
                    </div>
                    <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-3">
                        <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $stats['categories'] }}</div>
                        <div class="text-sm text-purple-600/70 dark:text-purple-400/70">Категорій</div>
                    </div>
                </div>
            </div>
            
            <!-- Sort Controls -->
            <div class="flex items-center gap-2">
                <flux:text class="text-sm text-zinc-600 dark:text-zinc-400">Сортувати:</flux:text>
                <div class="flex gap-1">
                    <flux:button 
                        size="sm" 
                        variant="{{ $sortBy === 'created_at' ? 'primary' : 'subtle' }}"
                        wire:click="sortBy('created_at')"
                    >
                        Дата додавання
                        @if($sortBy === 'created_at')
                            <flux:icon name="{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="w-3 h-3 ml-1" />
                        @endif
                    </flux:button>
                    <flux:button 
                        size="sm" 
                        variant="{{ $sortBy === 'title' ? 'primary' : 'subtle' }}"
                        wire:click="sortBy('title')"
                    >
                        Назва
                        @if($sortBy === 'title')
                            <flux:icon name="{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="w-3 h-3 ml-1" />
                        @endif
                    </flux:button>
                    <flux:button 
                        size="sm" 
                        variant="{{ $sortBy === 'published_at' ? 'primary' : 'subtle' }}"
                        wire:click="sortBy('published_at')"
                    >
                        Дата публікації
                        @if($sortBy === 'published_at')
                            <flux:icon name="{{ $sortDirection === 'asc' ? 'arrow-up' : 'arrow-down' }}" class="w-3 h-3 ml-1" />
                        @endif
                    </flux:button>
                </div>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6">
            <flux:callout variant="success" icon="check-circle">{{ session('message') }}</flux:callout>
        </div>
    @endif

    <!-- Search -->
    <div class="mb-6">
        <div class="relative max-w-md">
            <flux:field>
                <flux:label>Пошук закладок</flux:label>
                <div class="relative">
                    <flux:input 
                        wire:model.live.debounce.300ms="search"
                        placeholder="Пошук за назвою або описом..."
                        type="search"
                        class="pl-10 pr-10"
                    />
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <flux:icon name="magnifying-glass" class="w-4 h-4 text-zinc-400" />
                    </div>
                    @if($search)
                        <button 
                            wire:click="clearSearch"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-zinc-400 hover:text-zinc-600 transition-colors"
                            title="Очистити пошук"
                        >
                            <flux:icon name="x-mark" class="w-4 h-4" />
                        </button>
                    @else
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                            <kbd class="hidden sm:inline-flex items-center px-2 py-0.5 border border-zinc-200 dark:border-zinc-700 rounded text-xs text-zinc-500 bg-zinc-50 dark:bg-zinc-800">
                                Ctrl K
                            </kbd>
                        </div>
                    @endif
                </div>
            </flux:field>
        </div>
        @if($search)
            <div class="mt-2 text-sm text-zinc-600 dark:text-zinc-400">
                <span>Пошук за: "<strong>{{ $search }}</strong>" — знайдено {{ $bookmarks->total() }} {{ \Illuminate\Support\Str::plural('результат', $bookmarks->total()) }}</span>
            </div>
        @endif
    </div>

    <!-- Content -->
    @if($bookmarks->count() > 0)
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3" wire:loading.class="opacity-50 pointer-events-none" wire:target="search,sortBy">
            @foreach($bookmarks as $post)
                <div class="bookmark-card group bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 hover:border-zinc-300 dark:hover:border-zinc-600 hover:shadow-lg overflow-hidden animate-slide-in-up">
                    <!-- Loading overlay for individual cards -->
                    <div wire:loading.flex wire:target="removeBookmark({{ $post->id }})" class="absolute inset-0 bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm flex items-center justify-center z-10 rounded-xl">
                        <div class="flex items-center gap-2 text-zinc-600 dark:text-zinc-400">
                            <div class="animate-spin w-4 h-4 border-2 border-zinc-300 border-t-zinc-600 rounded-full"></div>
                            <span class="text-sm">Видалення...</span>
                        </div>
                    </div>

                    <!-- Card Header -->
                    <div class="p-6 pb-4">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="font-bold text-lg leading-tight group-hover:text-blue-600 transition-colors">
                                    <a href="{{ route('posts.show', $post->slug) }}" class="block">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                @if($post->user)
                                    <p class="text-sm text-zinc-500 mt-1">
                                        <flux:icon name="user" class="w-3 h-3 inline mr-1" />
                                        {{ $post->user->name }}
                                    </p>
                                @endif
                            </div>
                            <flux:button 
                                variant="danger"
                                size="sm"
                                wire:click="removeBookmark({{ $post->id }})"
                                wire:confirm="Видалити закладку?"
                                class="bookmark-remove-btn shrink-0 ml-2"
                                wire:loading.attr="disabled"
                                wire:target="removeBookmark({{ $post->id }})"
                            >
                                <flux:icon name="trash" class="w-4 h-4" />
                            </flux:button>
                        </div>
                        
                        @if($post->excerpt)
                            <p class="text-zinc-600 dark:text-zinc-400 text-sm line-clamp-3 mb-4">{{ $post->excerpt }}</p>
                        @endif
                    </div>

                    <!-- Card Content -->
                    <div class="px-6 pb-4">
                        <!-- Categories & Tags -->
                        @if($post->categories->count() > 0 || $post->tags->count() > 0)
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach($post->categories as $category)
                                    <flux:badge variant="primary" size="sm">
                                        <flux:icon name="folder" class="w-3 h-3 mr-1" />
                                        {{ $category->name }}
                                    </flux:badge>
                                @endforeach
                                @foreach($post->tags->take(2) as $tag)
                                    <flux:badge variant="subtle" size="sm">
                                        <flux:icon name="hashtag" class="w-3 h-3 mr-1" />
                                        {{ $tag->name }}
                                    </flux:badge>
                                @endforeach
                                @if($post->tags->count() > 2)
                                    <flux:badge variant="subtle" size="sm">
                                        +{{ $post->tags->count() - 2 }}
                                    </flux:badge>
                                @endif
                            </div>
                        @endif
                    </div>

                    <!-- Card Footer -->
                    <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-900/50 border-t border-zinc-200 dark:border-zinc-700">
                        <div class="flex items-center justify-between text-sm">
                            <div class="flex items-center text-zinc-500">
                                <flux:icon name="calendar" class="w-4 h-4 mr-1" />
                                {{ $post->published_at?->format('d.m.Y') }}
                            </div>
                            <div class="flex items-center text-zinc-500">
                                <flux:icon name="clock" class="w-4 h-4 mr-1" />
                                {{ $post->pivot->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <!-- Pagination -->
        <div class="mt-8">
            <div wire:loading.flex wire:target="gotoPage,previousPage,nextPage" class="justify-center mb-4">
                <div class="flex items-center gap-2 text-zinc-600 dark:text-zinc-400">
                    <div class="animate-spin w-4 h-4 border-2 border-zinc-300 border-t-zinc-600 rounded-full"></div>
                    <span class="text-sm">Завантаження...</span>
                </div>
            </div>
            {{ $bookmarks->links() }}
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16">
            <div class="mx-auto w-24 h-24 bg-zinc-100 dark:bg-zinc-800 rounded-full flex items-center justify-center mb-6">
                <flux:icon name="bookmark" class="w-12 h-12 text-zinc-400" />
            </div>
            <flux:heading size="lg" class="mb-2">
                @if($search)
                    Нічого не знайдено
                @else
                    Немає закладок
                @endif
            </flux:heading>
            <flux:text class="text-zinc-600 dark:text-zinc-400 mb-6">
                @if($search)
                    Не знайдено статей за запитом "{{ $search }}"
                    <br>
                    <button wire:click="clearSearch" class="text-blue-600 hover:text-blue-700 font-medium">
                        Очистити пошук
                    </button>
                @else
                    Почніть додавати статті до закладок під час читання
                @endif
            </flux:text>
            @unless($search)
                <flux:button 
                    href="{{ route('posts.index') }}" 
                    variant="primary"
                >
                    <flux:icon name="arrow-right" class="w-4 h-4 mr-2" />
                    Переглянути статті
                </flux:button>
            @endunless
        </div>
    @endif
</div>
