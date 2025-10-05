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