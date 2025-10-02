<footer class="w-full bg-zinc-50 border-t border-zinc-200 dark:bg-zinc-900 dark:border-zinc-700 mt-auto">
    <div class="mx-auto max-w-7xl px-6 py-12 lg:px-8">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-4">
            <!-- Company Info -->
            <div class="lg:col-span-1">
                <div class="flex items-center space-x-2 mb-4">
                    <x-app-logo />
                </div>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    Discover fascinating books, honest reviews, and literary insights. Your trusted companion in the world of literature, where every page turns into a new adventure.
                </p>
                <div class="mt-6 flex space-x-4">
                    <!-- Social Media Links -->
                    <a href="https://x.com/intent/tweet?text=Discover%20amazing%20book%20reviews%20and%20literary%20insights%20on%20this%20fantastic%20blog!&url={{ urlencode(request()->getSchemeAndHttpHost()) }}" target="_blank" rel="noopener noreferrer" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                        <span class="sr-only">Share on X</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                        </svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->getSchemeAndHttpHost()) }}&quote=Found%20an%20amazing%20literary%20blog%20with%20honest%20book%20reviews%20and%20reading%20recommendations!" target="_blank" rel="noopener noreferrer" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                        <span class="sr-only">Share on Facebook</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->getSchemeAndHttpHost()) }}&title=Literary%20Blog%20-%20Book%20Reviews%20%26%20Insights&summary=Discover%20thoughtful%20book%20reviews,%20literary%20analysis,%20and%20reading%20recommendations%20from%20passionate%20book%20lovers" target="_blank" rel="noopener noreferrer" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                        <span class="sr-only">Share on LinkedIn</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.338 16.338H13.67V12.16c0-.995-.017-2.277-1.387-2.277-1.39 0-1.601 1.086-1.601 2.207v4.248H8.014v-8.59h2.559v1.174h.037c.356-.675 1.227-1.387 2.526-1.387 2.703 0 3.203 1.778 3.203 4.092v4.711zM5.005 6.575a1.548 1.548 0 11-.003-3.096 1.548 1.548 0 01.003 3.096zm-1.337 9.763H6.34v-8.59H3.667v8.59zM17.668 1H2.328C1.595 1 1 1.581 1 2.298v15.403C1 18.418 1.595 19 2.328 19h15.34c.734 0 1.332-.582 1.332-1.299V2.298C19 1.581 18.402 1 17.668 1z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                    <a href="https://github.com/search?q=laravel+blog+livewire+filament&type=repositories" target="_blank" rel="noopener noreferrer" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                        <span class="sr-only">Find similar projects on GitHub</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 0C4.477 0 0 4.484 0 10.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0110 4.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.203 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.942.359.31.678.921.678 1.856 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0020 10.017C20 4.484 15.522 0 10 0z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                    <a href="https://api.whatsapp.com/send?text=Found%20this%20amazing%20book%20blog%20with%20great%20reviews%20and%20reading%20recommendations!%20{{ urlencode(request()->getSchemeAndHttpHost()) }}" target="_blank" rel="noopener noreferrer" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                        <span class="sr-only">Share on WhatsApp</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.520-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                    </a>
                    <a href="https://t.me/share/url?url={{ urlencode(request()->getSchemeAndHttpHost()) }}&text=Discover%20this%20fantastic%20literary%20blog%20with%20honest%20book%20reviews%20and%20reading%20insights!" target="_blank" rel="noopener noreferrer" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                        <span class="sr-only">Share on Telegram</span>
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M11.944 0A12 12 0 0 0 0 12a12 12 0 0 0 12 12 12 12 0 0 0 12-12A12 12 0 0 0 12 0a12 12 0 0 0-.056 0zm4.962 7.224c.1-.002.321.023.465.14a.506.506 0 0 1 .171.325c.016.093.036.306.02.472-.18 1.898-.962 6.502-1.36 8.627-.168.9-.499 1.201-.82 1.23-.696.065-1.225-.46-1.9-.902-1.056-.693-1.653-1.124-2.678-1.8-1.185-.78-.417-1.21.258-1.91.177-.184 3.247-2.977 3.307-3.23.007-.032.014-.15-.056-.212s-.174-.041-.249-.024c-.106.024-1.793 1.14-5.061 3.345-.48.33-.913.49-1.302.48-.428-.008-1.252-.241-1.865-.44-.752-.245-1.349-.374-1.297-.789.027-.216.325-.437.893-.663 3.498-1.524 5.83-2.529 6.998-3.014 3.332-1.386 4.025-1.627 4.476-1.635z"/>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Quick Links</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="{{ route('home') }}" class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100" wire:navigate>
                            Home
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('posts.index') }}" class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100" wire:navigate>
                            Blog
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100" wire:navigate>
                            Contact
                        </a>
                    </li>
                    @auth
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100" wire:navigate>
                                Dashboard
                            </a>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100" wire:navigate>
                                Login
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('register') }}" class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100" wire:navigate>
                                Register
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>

            <!-- Resources -->
            <div>
                <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Resources</h3>
                <ul class="space-y-3">
                    <li>
                        <a href="https://laravel.com/docs" target="_blank" class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                            Laravel Documentation
                        </a>
                    </li>
                    <li>
                        <a href="https://livewire.laravel.com" target="_blank" class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                            Livewire
                        </a>
                    </li>
                    <li>
                        <a href="https://fluxui.dev" target="_blank" class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                            Flux UI
                        </a>
                    </li>
                    <li>
                        <a href="https://github.com/laravel/livewire-starter-kit" target="_blank" class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                            Source Code
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Bottom Section -->
        <div class="mt-12 pt-8 border-t border-zinc-200 dark:border-zinc-700">
            <div class="flex flex-col items-center justify-between gap-4 md:flex-row">
                <p class="text-sm text-zinc-600 dark:text-zinc-400">
                    © {{ date('Y') }} Literary Insights. Sharing the love of books, one review at a time.
                </p>
                <div class="flex space-x-6">
                    <a href="#" class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                        Privacy Policy
                    </a>
                    <a href="#" class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100">
                        Terms of Service
                    </a>
                    <a href="{{ route('contact') }}" class="text-sm text-zinc-600 hover:text-zinc-900 dark:text-zinc-400 dark:hover:text-zinc-100" wire:navigate>
                        Contact
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>