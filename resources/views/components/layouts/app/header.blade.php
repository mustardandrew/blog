<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <div class="flex flex-col min-h-screen">
            <flux:header container class="relative border-b border-zinc-200/50 bg-gradient-to-r from-white via-zinc-50 to-white dark:border-zinc-700/50 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900 backdrop-blur-xl shadow-lg shadow-zinc-900/5 dark:shadow-zinc-900/20">
                <!-- Decorative gradient overlay -->
                <div class="absolute inset-0 bg-gradient-to-r from-blue-500/5 via-purple-500/5 to-cyan-500/5 dark:from-blue-400/10 dark:via-purple-400/10 dark:to-cyan-400/10"></div>
                
                <flux:sidebar.toggle class="lg:hidden relative z-10 p-2 rounded-lg hover:bg-zinc-100/80 dark:hover:bg-zinc-700/80 transition-colors duration-200" icon="bars-2" inset="left" />

                <a href="{{ route('home') }}" class="ms-2 me-5 flex items-center space-x-3 rtl:space-x-reverse lg:ms-0 relative z-10 group" wire:navigate>
                    <div class="p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors duration-200">
                        <x-app-logo />
                    </div>
                </a>

                <flux:navbar class="-mb-px max-lg:hidden z-10">
                    
                    <!-- Mega Menu -->
                    <div class="group z-10">
                        <button class="flex items-center gap-2 px-3 py-2 rounded-lg text-zinc-700 dark:text-zinc-300 hover:text-zinc-900 dark:hover:text-zinc-100 hover:bg-zinc-100 dark:hover:bg-zinc-700/50 transition-all duration-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <span class="font-medium">Menu</span>
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <!-- Mega Menu Dropdown -->
                        <div class="absolute bg-white dark:bg-zinc-900 shadow-2xl border border-zinc-200 dark:border-zinc-700 rounded-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 z-50 mt-2"
                             style="top: 100%; left: 0; right: 0; width: 100%; min-width: 400px; max-width: 1200px; margin: 0 auto;">
                            <div class="grid grid-cols-12 min-h-[400px]">
                                <!-- Left Navigation Menu -->
                                <div class="col-span-4 bg-zinc-50 dark:bg-zinc-800 rounded-l-2xl p-6 border-r border-zinc-200 dark:border-zinc-700">
                                    <h3 class="font-bold text-lg text-zinc-900 dark:text-zinc-100 mb-4">Navigation</h3>
                                    
                                    <nav class="space-y-2">
                                        <!-- Home -->
                                        <a href="{{ route('home') }}" 
                                           wire:navigate
                                           class="nav-item flex items-center gap-3 p-3 rounded-xl hover:bg-white dark:hover:bg-zinc-700 transition-all duration-200 group/nav">
                                            <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center group-hover/nav:scale-110 transition-transform">
                                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-zinc-900 dark:text-zinc-100">Home</span>
                                        </a>
                                        
                                        <!-- Blog Posts -->
                                        <a href="{{ route('posts.index') }}" 
                                           wire:navigate
                                           class="nav-item flex items-center gap-3 p-3 rounded-xl hover:bg-white dark:hover:bg-zinc-700 transition-all duration-200 group/nav">
                                            <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center group-hover/nav:scale-110 transition-transform">
                                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"></path>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-zinc-900 dark:text-zinc-100">Blog Posts</span>
                                        </a>
                                        
                                        <!-- Categories -->
                                        <div class="nav-item p-3 rounded-xl hover:bg-white dark:hover:bg-zinc-700 transition-all duration-200 group/nav cursor-pointer active-categories" 
                                             data-submenu="categories">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center group-hover/nav:scale-110 transition-transform">
                                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14-7l-7 7-7-7m14 14l-7-7-7 7"></path>
                                                    </svg>
                                                </div>
                                                <span class="font-medium text-zinc-900 dark:text-zinc-100">Categories</span>
                                                <svg class="w-4 h-4 ml-auto text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <!-- Pages -->
                                        <div class="nav-item p-3 rounded-xl hover:bg-white dark:hover:bg-zinc-700 transition-all duration-200 group/nav cursor-pointer active-pages" 
                                             data-submenu="pages">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-lg bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center group-hover/nav:scale-110 transition-transform">
                                                    <svg class="w-5 h-5 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                    </svg>
                                                </div>
                                                <span class="font-medium text-zinc-900 dark:text-zinc-100">Pages</span>
                                                <svg class="w-4 h-4 ml-auto text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        
                                        <!-- Contact -->
                                        <a href="{{ route('contact') }}" 
                                           wire:navigate
                                           class="nav-item flex items-center gap-3 p-3 rounded-xl hover:bg-white dark:hover:bg-zinc-700 transition-all duration-200 group/nav">
                                            <div class="w-10 h-10 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center group-hover/nav:scale-110 transition-transform">
                                                <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-zinc-900 dark:text-zinc-100">Contact</span>
                                        </a>
                                    </nav>
                                </div>
                                
                                <!-- Right Content Area -->
                                <div class="col-span-8 p-6 mega-menu-content">
                                    <!-- Categories Submenu -->
                                    <div id="submenu-categories" class="submenu hidden">
                                        <h3 class="font-bold text-xl text-zinc-900 dark:text-zinc-100 mb-6">Categories</h3>
                                        
                                        @if(isset($categories) && $categories->count() > 0)
                                            <div class="grid grid-cols-2 gap-6">
                                                @foreach($categories as $category)
                                                    <div class="space-y-3">
                                                        <!-- Parent Category -->
                                                        <a href="{{ route('categories.show', $category->slug) }}" 
                                                           wire:navigate
                                                           class="flex items-center gap-3 p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all duration-200 group">
                                                            <div class="w-3 h-3 rounded-full flex-shrink-0" 
                                                                 style="background-color: {{ $category->color ?? '#6366f1' }}"></div>
                                                            <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $category->name }}</span>
                                                            @if($category->children->count() > 0)
                                                                <span class="ml-auto text-xs bg-zinc-200 dark:bg-zinc-700 px-2 py-1 rounded-full">
                                                                    {{ $category->children->count() }}
                                                                </span>
                                                            @endif
                                                        </a>
                                                        
                                                        <!-- Child Categories -->
                                                        @if($category->children->count() > 0)
                                                            <div class="space-y-2 ml-6">
                                                                @foreach($category->children as $child)
                                                                    <a href="{{ route('categories.show', $child->slug) }}" 
                                                                       wire:navigate
                                                                       class="flex items-center gap-2 p-2 rounded-lg hover:bg-zinc-50 dark:hover:bg-zinc-800 transition-colors">
                                                                        <div class="w-2 h-2 rounded-full" 
                                                                             style="background-color: {{ $child->color ?? $category->color ?? '#6366f1' }}"></div>
                                                                        <span class="text-sm text-zinc-700 dark:text-zinc-300">{{ $child->name }}</span>
                                                                    </a>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-zinc-500 dark:text-zinc-400">No categories available</p>
                                        @endif
                                    </div>
                                    
                                    <!-- Pages Submenu -->
                                    <div id="submenu-pages" class="submenu hidden">
                                        <h3 class="font-bold text-xl text-zinc-900 dark:text-zinc-100 mb-6">Pages</h3>
                                        
                                        @if(isset($pages) && $pages->count() > 0)
                                            <div class="grid grid-cols-2 gap-4">
                                                @foreach($pages as $page)
                                                    <a href="{{ route('pages.show', $page->slug) }}" 
                                                       wire:navigate
                                                       class="flex items-center gap-3 p-4 rounded-xl bg-zinc-50 dark:bg-zinc-800 hover:bg-zinc-100 dark:hover:bg-zinc-700 transition-all duration-200">
                                                        <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                                                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                            </svg>
                                                        </div>
                                                        <span class="font-medium text-zinc-900 dark:text-zinc-100">{{ $page->title }}</span>
                                                    </a>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-zinc-500 dark:text-zinc-400">No pages available</p>
                                        @endif
                                    </div>
                                    
                                    <!-- Default Content -->
                                    <div id="default-content" class="submenu">
                                        <h3 class="font-bold text-xl text-zinc-900 dark:text-zinc-100 mb-6">Welcome to Our Blog</h3>
                                        <div class="grid grid-cols-2 gap-6">
                                            <div class="space-y-4">
                                                <h4 class="font-semibold text-zinc-900 dark:text-zinc-100">Latest Posts</h4>
                                                <p class="text-zinc-600 dark:text-zinc-400">Discover our newest articles and insights.</p>
                                                <a href="{{ route('posts.index') }}" 
                                                   wire:navigate
                                                   class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                                    View All Posts
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                            <div class="space-y-4">
                                                <h4 class="font-semibold text-zinc-900 dark:text-zinc-100">Get in Touch</h4>
                                                <p class="text-zinc-600 dark:text-zinc-400">Have questions? We'd love to hear from you.</p>
                                                <a href="{{ route('contact') }}" 
                                                   wire:navigate
                                                   class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                                    Contact Us
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script>
                        function initMegaMenu() {
                            const navItems = document.querySelectorAll('[data-submenu]');
                            const submenus = document.querySelectorAll('.submenu');
                            const defaultContent = document.getElementById('default-content');
                            const megaMenuContent = document.querySelector('.mega-menu-content');
                            const megaMenuContainer = document.querySelector('.group');
                            let currentActiveSubmenu = null;
                            
                            if (!navItems.length || !submenus.length || !defaultContent || !megaMenuContent || !megaMenuContainer) {
                                return; // Elements not found, exit
                            }
                            
                            function showSubmenu(submenuId) {
                                // Hide all submenus except default
                                submenus.forEach(submenu => {
                                    if (submenu.id !== 'default-content') {
                                        submenu.classList.add('hidden');
                                    }
                                });
                                
                                // Hide default content
                                defaultContent.classList.add('hidden');
                                
                                // Show target submenu
                                const targetSubmenu = document.getElementById(submenuId);
                                if (targetSubmenu) {
                                    targetSubmenu.classList.remove('hidden');
                                    currentActiveSubmenu = submenuId;
                                }
                            }
                            
                            function showDefault() {
                                // Hide all submenus
                                submenus.forEach(submenu => {
                                    if (submenu.id !== 'default-content') {
                                        submenu.classList.add('hidden');
                                    }
                                });
                                
                                // Show default
                                defaultContent.classList.remove('hidden');
                                currentActiveSubmenu = null;
                            }
                            
                            // Remove existing listeners to prevent duplicates
                            navItems.forEach(item => {
                                item.removeEventListener('mouseenter', item._megaMenuHandler);
                            });
                            
                            // Handle hover on navigation items
                            navItems.forEach(item => {
                                const handler = function() {
                                    const submenuId = 'submenu-' + this.dataset.submenu;
                                    showSubmenu(submenuId);
                                };
                                item._megaMenuHandler = handler;
                                item.addEventListener('mouseenter', handler);
                            });
                            
                            // Keep submenu visible when hovering over content area
                            if (megaMenuContent._megaMenuContentHandler) {
                                megaMenuContent.removeEventListener('mouseenter', megaMenuContent._megaMenuContentHandler);
                            }
                            megaMenuContent._megaMenuContentHandler = function() {
                                // Do nothing - keep current submenu visible
                            };
                            megaMenuContent.addEventListener('mouseenter', megaMenuContent._megaMenuContentHandler);
                            
                            // Reset to default when leaving navigation area
                            const leftNav = document.querySelector('.col-span-4');
                            if (leftNav) {
                                if (leftNav._megaMenuNavHandler) {
                                    leftNav.removeEventListener('mouseleave', leftNav._megaMenuNavHandler);
                                }
                                leftNav._megaMenuNavHandler = function(e) {
                                    // Only reset if not moving to content area
                                    setTimeout(() => {
                                        if (!megaMenuContent.matches(':hover')) {
                                            showDefault();
                                        }
                                    }, 50);
                                };
                                leftNav.addEventListener('mouseleave', leftNav._megaMenuNavHandler);
                            }
                            
                            // Reset when leaving entire mega menu
                            if (megaMenuContainer._megaMenuContainerHandler) {
                                megaMenuContainer.removeEventListener('mouseleave', megaMenuContainer._megaMenuContainerHandler);
                            }
                            megaMenuContainer._megaMenuContainerHandler = function() {
                                showDefault();
                            };
                            megaMenuContainer.addEventListener('mouseleave', megaMenuContainer._megaMenuContainerHandler);
                        }
                        
                        // Initialize on page load
                        document.addEventListener('DOMContentLoaded', initMegaMenu);
                        
                        // Re-initialize after Livewire navigation
                        document.addEventListener('livewire:navigated', initMegaMenu);
                        
                        // Fallback for browsers that don't support livewire:navigated
                        document.addEventListener('livewire:load', initMegaMenu);
                    </script>
                    
                    <flux:navbar.item 
                        icon="envelope" 
                        :href="route('contact')" 
                        :current="request()->routeIs('contact')" 
                        wire:navigate
                        class="px-3 py-2 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700/50 transition-all duration-200 hover:shadow-sm"
                    >
                        {{ __('Contact') }}
                    </flux:navbar.item>
                </flux:navbar>

                <flux:spacer />

                <flux:navbar class="me-1.5 space-x-0.5 rtl:space-x-reverse py-0! relative z-10">
                    <flux:tooltip :content="__('Search')" position="bottom">
                        <flux:navbar.item 
                            class="!h-10 [&>div>svg]:size-5 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700/50 transition-all duration-200" 
                            icon="magnifying-glass" 
                            href="#" 
                            :label="__('Search')"
                        />
                    </flux:tooltip>
                </flux:navbar>

                <!-- Theme Toggle -->
                <flux:dropdown x-data align="end" class="hidden lg:block relative z-10">
                    <flux:button 
                        variant="subtle" 
                        square 
                        class="rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700/50 transition-all duration-200" 
                        aria-label="Preferred color scheme"
                    >
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
                <flux:dropdown position="top" align="end" class="relative z-10">
                    <flux:profile
                        class="cursor-pointer hover:opacity-80 transition-opacity duration-200"
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
                                <flux:menu.item :href="route('dashboard')" icon="cog" wire:navigate>{{ __('Dashboard') }}</flux:menu.item>
                                <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Profile') }}</flux:menu.item>
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
