<div class="bg-gradient-to-br from-amber-50 via-orange-50 to-yellow-50 dark:from-zinc-900 dark:via-zinc-800 dark:to-amber-900/20 rounded-lg p-8 text-center border border-amber-200/50 dark:border-amber-800/30">
    @if($isSubscribed)
        <!-- Success State -->
        <div class="max-w-md mx-auto">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            <flux:heading size="lg" class="mb-4 text-amber-800 dark:text-amber-200">Subscribed!</flux:heading>
            <flux:text class="text-amber-700 dark:text-amber-300 mb-6">
                {{ $message }}
            </flux:text>
            <flux:button wire:click="resetForm" variant="outline" class="border-amber-300 text-amber-700 hover:bg-amber-50 dark:border-amber-600 dark:text-amber-400 dark:hover:bg-amber-900/20">
                Subscribe Another Email
            </flux:button>
        </div>
    @else
        <!-- Subscription Form -->
        <div class="max-w-md mx-auto">
            <div class="flex justify-center mb-4">
                <div class="w-16 h-16 bg-gradient-to-r from-amber-500 to-orange-500 rounded-full flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            
            <flux:heading size="lg" class="mb-4 text-amber-800 dark:text-amber-200">Subscribe to Our Newsletter</flux:heading>
            <flux:text class="text-amber-700 dark:text-amber-300 mb-6">
                Get the latest articles and insights delivered directly to your inbox. No spam, unsubscribe at any time.
            </flux:text>
            
            <form wire:submit="subscribe" class="space-y-4">
                @guest
                    <div>
                        <flux:input 
                            wire:model.live.debounce.500ms="name" 
                            placeholder="Your name (optional)"
                        />
                        @error('name') 
                            <div class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div>
                        <flux:input 
                            wire:model.live.debounce.500ms="email" 
                            type="email" 
                            placeholder="Enter your email address"
                            required
                        />
                        @error('email') 
                            <div class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                @else
                    <div>
                        <flux:input 
                            wire:model="email" 
                            type="email" 
                            placeholder="Enter your email address"
                            readonly
                            required
                        />
                        @error('email') 
                            <div class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                @endguest
                
                <button 
                    type="submit" 
                    class="w-full bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-semibold py-3 rounded-lg shadow-lg shadow-amber-500/25 transition-all duration-200 transform hover:scale-105 disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                    wire:loading.attr="disabled"
                >
                    <span wire:loading.remove>
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                        </svg>
                        Subscribe Now
                    </span>
                    <span wire:loading>
                        <svg class="w-5 h-5 mr-2 inline animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        Subscribing...
                    </span>
                </button>
            </form>
            
            <flux:text class="text-xs text-amber-600 dark:text-amber-400 mt-4">
                By subscribing, you agree to receive email updates. You can unsubscribe at any time.
            </flux:text>
        </div>
    @endif
</div>
