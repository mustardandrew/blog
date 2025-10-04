<div>
    <!-- Search Panel Overlay -->
    <div 
        x-data="{ isOpen: @entangle('isOpen') }"
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 bg-black/50 backdrop-blur-sm"
        style="display: none;"
        @click="$wire.closeSearch()"
        @keydown.escape.window="$wire.closeSearch()"
    >
        <!-- Search Panel -->
        <div 
            class="absolute top-16 left-0 right-0 mx-auto max-w-2xl bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-700 overflow-hidden"
            @click.stop
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
        >
            <!-- Search Input -->
            <div class="p-4 border-b border-zinc-200 dark:border-zinc-700">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input
                        wire:model.live.debounce.300ms="query"
                        x-ref="searchInput"
                        x-init="$wire.on('focus-search-input', () => { setTimeout(() => $refs.searchInput.focus(), 50) })"
                        type="text"
                        class="block w-full pl-10 pr-3 py-3 border-0 text-zinc-900 dark:text-zinc-100 bg-transparent placeholder-zinc-500 focus:ring-2 focus:ring-blue-500 focus:outline-none text-lg"
                        placeholder="Шукати статті..."
                        autocomplete="off"
                    >
                    
                    <!-- Close button -->
                    <button 
                        @click="$wire.closeSearch()"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center hover:text-zinc-700 dark:hover:text-zinc-300 transition-colors"
                    >
                        <svg class="h-6 w-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Search Results -->
            <div class="max-h-96 overflow-y-auto">
                @if(strlen($query) >= 2)
                    @if($results->count() > 0)
                        <div class="py-2">
                            @foreach($results as $post)
                                <a 
                                    href="{{ route('posts.show', $post->slug) }}" 
                                    wire:navigate
                                    @click="$wire.closeSearch()"
                                    class="block px-4 py-3 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors border-b border-zinc-100 dark:border-zinc-800 last:border-b-0"
                                >
                                    <div class="flex items-start gap-3">
                                        @if($post->featured_image)
                                            <img 
                                                src="{{ $post->featured_image_url }}" 
                                                alt="{{ $post->title }}"
                                                class="w-12 h-12 rounded-lg object-cover flex-shrink-0"
                                            >
                                        @else
                                            <div class="w-12 h-12 rounded-lg bg-zinc-200 dark:bg-zinc-700 flex items-center justify-center flex-shrink-0">
                                                <svg class="w-6 h-6 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2H15"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        
                                        <div class="flex-1 min-w-0">
                                            <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 truncate">
                                                {{ $post->title }}
                                            </h3>
                                            
                                            @if($post->excerpt)
                                                <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-1 line-clamp-2">
                                                    {{ $post->excerpt }}
                                                </p>
                                            @endif
                                            
                                            <div class="flex items-center gap-2 mt-2">
                                                <span class="text-xs text-zinc-500">{{ $post->user->name }}</span>
                                                <span class="text-xs text-zinc-400">•</span>
                                                <span class="text-xs text-zinc-500">{{ $post->published_at->format('d.m.Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        
                        <!-- View all results -->
                        @if($results->count() >= 8)
                            <div class="p-4 border-t border-zinc-200 dark:border-zinc-700">
                                <a 
                                    href="{{ route('posts.index', ['search' => $query]) }}" 
                                    wire:navigate
                                    @click="$wire.closeSearch()"
                                    class="block w-full text-center py-2 px-4 bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors font-medium"
                                >
                                    Переглянути всі результати для "{{ $query }}"
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="p-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-100">Нічого не знайдено</h3>
                            <p class="mt-1 text-sm text-zinc-500">Спробуйте інший пошуковий запит</p>
                        </div>
                    @endif
                @elseif(strlen($query) > 0)
                    <div class="p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <p class="mt-2 text-sm text-zinc-500">Введіть мінімум 2 символи для пошуку</p>
                    </div>
                @else
                    <div class="p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-zinc-900 dark:text-zinc-100">Швидкий пошук</h3>
                        <p class="mt-1 text-sm text-zinc-500">Знайдіть статті за назвою або змістом</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
