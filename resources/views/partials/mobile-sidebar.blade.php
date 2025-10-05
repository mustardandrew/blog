<flux:sidebar stashable sticky class="lg:hidden border-e border-zinc-200/50 bg-gradient-to-b from-white via-zinc-50 to-white dark:border-zinc-700/50 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900 backdrop-blur-xl shadow-xl shadow-zinc-900/10 dark:shadow-zinc-900/30">
    <!-- Decorative gradient overlay for mobile -->
    <div class="absolute inset-0 bg-gradient-to-b from-blue-500/5 via-purple-500/5 to-cyan-500/5 dark:from-blue-400/10 dark:via-purple-400/10 dark:to-cyan-400/10"></div>
    
    <flux:sidebar.toggle class="lg:hidden relative z-10 p-2 rounded-lg hover:bg-zinc-100/80 dark:hover:bg-zinc-700/80 transition-colors duration-200" icon="x-mark" />

    <a href="{{ route('dashboard') }}" class="ms-1 flex items-center space-x-3 rtl:space-x-reverse relative z-10" wire:navigate>
        <div class="p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors duration-200">
            <x-app-logo />
        </div>
    </a>

    <flux:navlist variant="outline">
        <flux:navlist.group :heading="__('Platform')">
            <flux:navlist.item icon="layout-grid" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                {{ __('Home') }}
            </flux:navlist.item>
            <flux:navlist.item icon="rectangle-stack" :href="route('posts.index')" :current="request()->routeIs('posts.*')" wire:navigate>
                {{ __('Blog') }}
            </flux:navlist.item>
            <flux:navlist.item icon="envelope" :href="route('contact')" :current="request()->routeIs('contact')" wire:navigate>
                {{ __('Contact') }}
            </flux:navlist.item>
            @auth
                <flux:navlist.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navlist.item>
            @endauth
        </flux:navlist.group>
        
        @if(isset($categories) && $categories->count() > 0)
            <flux:navlist.group :heading="__('Categories')">
                @foreach($categories as $category)
                    <flux:navlist.item 
                        icon="folder" 
                        :href="route('categories.show', $category->slug)" 
                        :current="request()->routeIs('categories.show') && request()->route('category')?->slug === $category->slug"
                        wire:navigate
                        class="font-medium"
                    >
                        {{ $category->name }}
                    </flux:navlist.item>
                    
                    @if($category->children->count() > 0)
                        @foreach($category->children as $child)
                            <flux:navlist.item 
                                icon="folder-open" 
                                :href="route('categories.show', $child->slug)" 
                                :current="request()->routeIs('categories.show') && request()->route('category')?->slug === $child->slug"
                                wire:navigate
                                class="ml-6 text-sm text-zinc-600 dark:text-zinc-400 border-l-2 border-zinc-200 dark:border-zinc-700 pl-3"
                            >
                                {{ $child->name }}
                            </flux:navlist.item>
                        @endforeach
                    @endif
                @endforeach
            </flux:navlist.group>
        @endif
    </flux:navlist>


    <!-- Mobile Theme Toggle -->
    <div class="px-4 py-2 relative z-10">
        <div class="p-3 rounded-lg bg-zinc-50 dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700">
            <flux:field>
                <flux:label class="text-zinc-900 dark:text-zinc-100 font-medium text-sm">{{ __('Theme') }}</flux:label>
                <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class="grid grid-cols-3 gap-1 mt-2">
                    <flux:radio value="light" icon="sun" @click="$flux.appearance = 'light'" class="hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"></flux:radio>
                    <flux:radio value="dark" icon="moon" @click="$flux.appearance = 'dark'" class="hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"></flux:radio>
                    <flux:radio value="system" icon="computer-desktop" @click="$flux.appearance = 'system'" class="hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-colors"></flux:radio>
                </flux:radio.group>
            </flux:field>
        </div>
    </div>
</flux:sidebar>