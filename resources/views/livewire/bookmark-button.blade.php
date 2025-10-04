<div>
    <flux:button 
        wire:click="toggle"
        :variant="$isBookmarked ? 'primary' : $variant"
        :size="$size"
        class="group relative transition-all duration-200 hover:scale-105"
        :class="$isBookmarked ? 'bg-amber-500 hover:bg-amber-600 text-white' : 'hover:bg-amber-50 hover:border-amber-300 hover:text-amber-700'"
        x-data="{ bookmarked: @js($isBookmarked) }"
        x-on:bookmark-toggled.window="if ($event.detail.postId === {{ $post->id }}) bookmarked = $event.detail.bookmarked"
        x-bind:class="bookmarked ? 'bg-amber-500 hover:bg-amber-600 text-white border-amber-500' : ''"
    >
        <div class="flex items-center gap-2">
            <!-- Bookmark Icon -->
            @php
                $iconSize = match($size) {
                    'xs' => 'w-3 h-3',
                    'sm' => 'w-4 h-4',
                    'lg' => 'w-5 h-5',
                    'xl' => 'w-6 h-6',
                    default => 'w-4 h-4'
                };
                
                $showText = in_array($size, ['lg', 'xl']);
            @endphp
            
            <svg 
                class="{{ $iconSize }} transition-all duration-200"
                :class="$isBookmarked ? 'fill-current' : 'fill-none'"
                x-bind:class="bookmarked ? 'fill-current' : 'fill-none'"
                stroke="currentColor" 
                viewBox="0 0 24 24"
            >
                <path 
                    stroke-linecap="round" 
                    stroke-linejoin="round" 
                    stroke-width="2" 
                    d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"
                />
            </svg>
            
            <!-- Text (only for lg and xl sizes) -->
            @if($showText)
                <span class="text-sm font-medium">
                    <span x-show="!bookmarked">{{ $isBookmarked ? 'Видалити' : 'Зберегти' }}</span>
                    <span x-show="bookmarked" x-cloak>Збережено</span>
                </span>
            @endif
        </div>

        <!-- Loading state -->
        <div wire:loading.flex wire:target="toggle" class="absolute inset-0 items-center justify-center bg-white bg-opacity-80 rounded">
            <svg class="{{ $iconSize }} animate-spin text-amber-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </flux:button>

    <!-- Success/Error Messages -->
    @if (session()->has('message'))
        <div 
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 transform translate-y-2"
            x-transition:enter-end="opacity-100 transform translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 transform translate-y-0"
            x-transition:leave-end="opacity-0 transform translate-y-2"
            class="absolute top-full left-0 mt-2 px-3 py-2 bg-green-100 border border-green-200 text-green-800 text-sm rounded-lg shadow-lg z-50 whitespace-nowrap"
        >
            {{ session('message') }}
        </div>
    @endif
</div>