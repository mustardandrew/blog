<div class="bg-white dark:bg-zinc-900 rounded-2xl border border-zinc-200 dark:border-zinc-700 p-8 shadow-sm">
    @if (session()->has('contact_success'))
        <flux:callout variant="success" class="mb-6">
            <flux:callout.text>
                {{ session('contact_success') }}
            </flux:callout.text>
        </flux:callout>
    @endif

    <form wire:submit="submit" class="space-y-6">
        <!-- Name Field -->
        <div>
            <flux:field>
                <flux:label for="name">Name <span class="text-red-500">*</span></flux:label>
                <flux:input 
                    id="name"
                    wire:model="name" 
                    placeholder="Your full name"
                    autocomplete="name"
                />
                <flux:error name="name" />
            </flux:field>
        </div>

        <!-- Email Field -->
        <div>
            <flux:field>
                <flux:label for="email">Email <span class="text-red-500">*</span></flux:label>
                <flux:input 
                    id="email"
                    type="email"
                    wire:model="email" 
                    placeholder="your.email@example.com"
                    autocomplete="email"
                />
                <flux:error name="email" />
            </flux:field>
        </div>

        <!-- Subject Field -->
        <div>
            <flux:field>
                <flux:label for="subject">Subject <span class="text-red-500">*</span></flux:label>
                <flux:input 
                    id="subject"
                    wire:model="subject" 
                    placeholder="What is your message about?"
                />
                <flux:error name="subject" />
            </flux:field>
        </div>

        <!-- Message Field -->
        <div>
            <flux:field>
                <flux:label for="message">Message <span class="text-red-500">*</span></flux:label>
                <flux:textarea 
                    id="message"
                    wire:model="message" 
                    placeholder="Tell us what's on your mind..."
                    rows="6"
                />
                <flux:error name="message" />
                <div class="text-sm text-zinc-500 dark:text-zinc-400 mt-1">
                    Minimum 10 characters
                </div>
            </flux:field>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-end">
            <flux:button 
                type="submit" 
                variant="primary" 
                wire:loading.attr="disabled"
                wire:loading.class="opacity-50"
                class="px-8"
            >
                <span wire:loading.remove>Send Message</span>
                <span wire:loading class="flex items-center">
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Sending...
                </span>
            </flux:button>
        </div>
    </form>
</div>
