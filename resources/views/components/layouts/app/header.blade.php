<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <div class="flex flex-col min-h-screen">
            <flux:header container class="border-b border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

                <a href="{{ route('home') }}" class="ms-2 me-5 flex items-center space-x-2 rtl:space-x-reverse lg:ms-0" wire:navigate>
                    <x-app-logo />
                </a>

                <flux:navbar class="-mb-px max-lg:hidden">
                    
                    <flux:navbar.item icon="rectangle-stack" :href="route('posts.index')" :current="request()->routeIs('posts.*')" wire:navigate>
                        {{ __('Blog') }}
                    </flux:navbar.item>
                    
                    <flux:navbar.item icon="envelope" :href="route('contact')" :current="request()->routeIs('contact')" wire:navigate>
                        {{ __('Contact') }}
                    </flux:navbar.item>
                    
                    @auth
                        <flux:navbar.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                            {{ __('Dashboard') }}
                        </flux:navbar.item>
                    @endauth
                </flux:navbar>

                <flux:spacer />

                <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0!">
                    <flux:tooltip :content="__('Search')" position="bottom">
                        <flux:navbar.item class="!h-10 [&>div>svg]:size-5" icon="magnifying-glass" href="#" :label="__('Search')" />
                    </flux:tooltip>
                    <flux:tooltip :content="__('Repository')" position="bottom">
                        <flux:navbar.item
                            class="h-10 max-lg:hidden [&>div>svg]:size-5"
                            icon="folder-git-2"
                            href="https://github.com/laravel/livewire-starter-kit"
                            target="_blank"
                            :label="__('Repository')"
                        />
                    </flux:tooltip>
                    <flux:tooltip :content="__('Documentation')" position="bottom">
                        <flux:navbar.item
                            class="h-10 max-lg:hidden [&>div>svg]:size-5"
                            icon="book-open-text"
                            href="https://laravel.com/docs/starter-kits#livewire"
                            target="_blank"
                            label="Documentation"
                        />
                    </flux:tooltip>
                </flux:navbar>

                <!-- Theme Toggle -->
                <flux:dropdown x-data align="end" class="hidden lg:block">
                    <flux:button variant="subtle" square class="group" aria-label="Preferred color scheme">
                        <flux:icon.sun x-show="$flux.appearance === 'light'" variant="mini" class="text-zinc-500 dark:text-white" />
                        <flux:icon.moon x-show="$flux.appearance === 'dark'" variant="mini" class="text-zinc-500 dark:text-white" />
                        <flux:icon.moon x-show="$flux.appearance === 'system' && $flux.dark" variant="mini" />
                        <flux:icon.sun x-show="$flux.appearance === 'system' && ! $flux.dark" variant="mini" />
                    </flux:button>
                    <flux:menu>
                        <flux:menu.item icon="sun" x-on:click="$flux.appearance = 'light'">Light</flux:menu.item>
                        <flux:menu.item icon="moon" x-on:click="$flux.appearance = 'dark'">Dark</flux:menu.item>
                        <flux:menu.item icon="computer-desktop" x-on:click="$flux.appearance = 'system'">System</flux:menu.item>
                    </flux:menu>
                </flux:dropdown>

                <!-- Desktop User Menu -->
                <flux:dropdown position="top" align="end">
                    <flux:profile
                        class="cursor-pointer"
                        :initials="auth()->user() ? auth()->user()->initials() : ''"
                    />

                    <flux:menu>
                        @auth
                            <flux:menu.radio.group>
                                <div class="p-0 text-sm font-normal">
                                    <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                        <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                            <span
                                                class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                            >
                                                {{ auth()->user()->initials() }}
                                            </span>
                                        </span>

                                        <div class="grid flex-1 text-start text-sm leading-tight">
                                            <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                            <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                        </div>
                                    </div>
                                </div>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <flux:menu.radio.group>
                                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                            </flux:menu.radio.group>

                            <flux:menu.separator />

                            <form method="POST" action="{{ route('logout') }}" class="w-full">
                                @csrf
                                <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full" data-test="logout-button">
                                    {{ __('Log Out') }}
                                </flux:menu.item>
                            </form>

                        @else
                            <flux:menu.radio.group>
                                <flux:menu.item :href="route('login')" icon="arrow-left-end-on-rectangle" wire:navigate>{{ __('Login') }}</flux:menu.item>
                            </flux:menu.radio.group>
                            <flux:menu.radio.group>
                                <flux:menu.item :href="route('register')" icon="user-plus" wire:navigate>{{ __('Register') }}</flux:menu.item>
                            </flux:menu.radio.group>
                        @endauth

                    </flux:menu>
                </flux:dropdown>
            </flux:header>

            <!-- Mobile Menu -->
            <flux:sidebar stashable sticky class="lg:hidden border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
                <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

                <a href="{{ route('dashboard') }}" class="ms-1 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                    <x-app-logo />
                </a>

                <flux:navlist variant="outline">
                    <flux:navlist.group :heading="__('Platform')">
                        <flux:navlist.item icon="layout-grid" :href="route('home')" :current="request()->routeIs('home')" wire:navigate>
                            {{ __('Home') }}
                        </flux:navlist.item>
                        @auth
                            <flux:navlist.item icon="layout-grid" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                                {{ __('Dashboard') }}
                            </flux:navlist.item>
                        @endauth
                    </flux:navlist.group>
                </flux:navlist>

                <flux:spacer />

                <flux:navlist variant="outline">
                    <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                    {{ __('Repository') }}
                    </flux:navlist.item>

                    <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                    {{ __('Documentation') }}
                    </flux:navlist.item>
                </flux:navlist>

                <!-- Mobile Theme Toggle -->
                <div class="px-4 py-2">
                    <flux:field>
                        <flux:label>{{ __('Theme') }}</flux:label>
                        <flux:radio.group x-data variant="segmented" x-model="$flux.appearance" class="grid grid-cols-3 gap-1">
                            <flux:radio value="light" icon="sun" @click="$flux.appearance = 'light'"></flux:radio>
                            <flux:radio value="dark" icon="moon" @click="$flux.appearance = 'dark'"></flux:radio>
                            <flux:radio value="system" icon="computer-desktop" @click="$flux.appearance = 'system'"></flux:radio>
                        </flux:radio.group>
                    </flux:field>
                </div>
            </flux:sidebar>

            <main class="flex-1 lg:ml-0">
                {{ $slot }}
            </main>
            
            <!-- Newsletter Subscription Section -->
<section class="relative bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 dark:from-zinc-900 dark:via-zinc-800 dark:to-amber-900/20 overflow-hidden">
    <!-- Gradient Background Elements -->
    <div class="absolute inset-0 bg-gradient-to-r from-amber-400/10 via-orange-400/10 to-yellow-400/10 dark:from-amber-600/10 dark:via-orange-600/10 dark:to-yellow-600/10"></div>
    <div class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-amber-300/20 to-orange-300/20 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute bottom-0 right-0 w-80 h-80 bg-gradient-to-tl from-yellow-300/20 to-amber-300/20 rounded-full blur-3xl translate-x-1/2 translate-y-1/2"></div>
    
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Column - Description -->
            <div class="space-y-6">
                <div class="space-y-4">
                    <h2 class="text-3xl lg:text-4xl font-bold bg-gradient-to-r from-amber-600 via-orange-600 to-yellow-600 dark:from-amber-400 dark:via-orange-400 dark:to-yellow-400 bg-clip-text text-transparent">
                        Stay in the Literary Loop
                    </h2>
                    <p class="text-lg text-zinc-700 dark:text-zinc-300 leading-relaxed">
                        Get the latest book reviews, literary insights, and reading recommendations delivered straight to your inbox. Join our community of book lovers and never miss a great read.
                    </p>
                </div>
                
                <!-- Features List -->
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-5 h-5 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-zinc-700 dark:text-zinc-300">Weekly book recommendations</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-5 h-5 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-zinc-700 dark:text-zinc-300">Exclusive literary insights</span>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0 w-5 h-5 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <span class="text-zinc-700 dark:text-zinc-300">Early access to new reviews</span>
                    </div>
                </div>
            </div>
            
            <!-- Right Column - Form -->
            <div class="lg:pl-8">
                <div class="bg-white/80 dark:bg-zinc-800/80 backdrop-blur-sm rounded-2xl p-8 shadow-xl shadow-amber-500/10 dark:shadow-amber-500/5">
                    <livewire:newsletter-subscription />
                </div>
            </div>
        </div>
    </div>
</section>
            
            <x-layouts.app.footer />
        
        </div>

        @fluxScripts
    </body>
</html>
