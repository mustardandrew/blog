<x-layouts.app 
    title="Contact Us - Get In Touch"
    description="Have a question or want to get in touch? Send us a message and we'll get back to you as soon as possible.">
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <flux:breadcrumbs class="mb-8">
            <flux:breadcrumbs.item href="{{ route('home') }}">Home</flux:breadcrumbs.item>
            <flux:breadcrumbs.item>Contact</flux:breadcrumbs.item>
        </flux:breadcrumbs>

        <!-- Hero Section -->
        <div class="relative mb-12">
            <div class="bg-gradient-to-br from-green-50 via-teal-50 to-blue-50 dark:from-zinc-900 dark:via-zinc-800 dark:to-green-900/20 rounded-2xl border border-green-200/50 dark:border-green-800/30 p-12 text-center">
                <!-- Decorative background elements -->
                <div class="absolute inset-0 bg-grid-green-100/50 dark:bg-grid-green-800/20 opacity-30 rounded-2xl"></div>
                <div class="absolute top-0 right-0 -translate-y-6 translate-x-6 transform">
                    <div class="w-32 h-32 bg-gradient-to-br from-green-400/20 to-teal-400/20 rounded-full blur-2xl"></div>
                </div>
                
                <div class="relative">
                    <flux:heading size="xl" class="mb-6 text-4xl sm:text-5xl lg:text-6xl bg-gradient-to-r from-green-600 via-teal-600 to-blue-600 dark:from-green-400 dark:via-teal-400 dark:to-blue-400 bg-clip-text text-transparent font-bold">
                        Get In Touch
                    </flux:heading>
                    
                    <flux:text class="text-xl leading-relaxed text-zinc-700 dark:text-zinc-300 max-w-3xl mx-auto mb-6">
                        Have a question, suggestion, or just want to say hello? We'd love to hear from you. Send us a message and we'll get back to you as soon as possible.
                    </flux:text>

                    <!-- Contact Info -->
                    <div class="flex flex-wrap justify-center items-center gap-6 text-sm text-zinc-600 dark:text-zinc-400">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Response within 24 hours
                        </div>
                        
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                            </svg>
                            Your privacy is protected
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Contact Form -->
            <div class="lg:col-span-2">
                <div class="mb-6">
                    <flux:heading size="lg" class="mb-2">Send us a message</flux:heading>
                    <flux:text class="text-zinc-600 dark:text-zinc-400">
                        Fill out the form below and we'll get back to you as soon as possible.
                    </flux:text>
                </div>

                <livewire:contact-form />
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Contact Info Card -->
                <div class="bg-gradient-to-br from-green-50 to-teal-50 dark:from-zinc-800 dark:to-green-900/20 rounded-xl border border-green-200/50 dark:border-green-800/30 p-6">
                    <flux:heading size="base" class="mb-4 text-green-900 dark:text-green-100">Other ways to reach us</flux:heading>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-green-800 dark:text-green-200">Email</div>
                                <div class="text-sm text-green-700 dark:text-green-300">hello@litblog.com</div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-green-800 dark:text-green-200">Response Time</div>
                                <div class="text-sm text-green-700 dark:text-green-300">Usually within 24 hours</div>
                            </div>
                        </div>

                        <div class="flex items-start">
                            <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-lg flex items-center justify-center mr-3">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <div>
                                <div class="font-medium text-green-800 dark:text-green-200">Location</div>
                                <div class="text-sm text-green-700 dark:text-green-300">Online worldwide</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- FAQ Card -->
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
                    <flux:heading size="base" class="mb-4">Frequently Asked</flux:heading>
                    
                    <div class="space-y-4 text-sm">
                        <div>
                            <div class="font-medium text-zinc-900 dark:text-zinc-100 mb-1">📚 Book recommendations?</div>
                            <div class="text-zinc-600 dark:text-zinc-400">We love sharing book suggestions! Tell us your favorite genres.</div>
                        </div>

                        <div>
                            <div class="font-medium text-zinc-900 dark:text-zinc-100 mb-1">✍️ Guest posting?</div>
                            <div class="text-zinc-600 dark:text-zinc-400">Interested writers are welcome to pitch their book review ideas.</div>
                        </div>

                        <div>
                            <div class="font-medium text-zinc-900 dark:text-zinc-100 mb-1">🤝 Collaboration?</div>
                            <div class="text-zinc-600 dark:text-zinc-400">Publishers and authors, let's discuss potential partnerships.</div>
                        </div>
                    </div>
                </div>

                <!-- Quick Navigation -->
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
                    <flux:heading size="base" class="mb-4">Quick Links</flux:heading>
                    
                    <div class="space-y-2">
                        <a href="{{ route('home') }}" 
                           wire:navigate
                           class="flex items-center text-sm text-zinc-600 dark:text-zinc-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                            </svg>
                            Back to Home
                        </a>
                        
                        <a href="{{ route('posts.index') }}" 
                           wire:navigate
                           class="flex items-center text-sm text-zinc-600 dark:text-zinc-400 hover:text-green-600 dark:hover:text-green-400 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Browse Reviews
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>