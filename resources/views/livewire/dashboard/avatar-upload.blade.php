<div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 shadow-sm">
    {{-- Success/Error Messages --}}
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <p class="text-green-800 dark:text-green-300 text-sm font-medium">
                {{ __(session('message')) }}
            </p>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
            <p class="text-red-800 dark:text-red-300 text-sm font-medium">
                {{ __(session('error')) }}
            </p>
        </div>
    @endif

    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">
                {{ __('User\'s Avatar') }}
            </h2>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                {{ __('Update your avatar or leave the field empty to use Gravatar') }}
            </p>
            <x-ui.separator />
        </div>

        {{-- Current Avatar Display --}}
        <div class="flex items-center gap-6">
            <div class="relative">
                <img 
                    src="{{ $this->avatarUrl }}" 
                    alt="{{ __('Current Avatar') }}" 
                    class="w-20 h-20 rounded-full object-cover border-2 border-zinc-200 dark:border-zinc-700"
                >
            </div>
            
            <div class="flex-1">
                <h3 class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ __('Current Avatar') }}</h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                    {{ __('Supported formats: JPEG, PNG, GIF, WebP (up to 10MB)') }}
                </p>
            </div>
        </div>

        {{-- Upload Form --}}
        <div class="space-y-4">
            <flux:field>
                <flux:label class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                    {{ __('Upload new avatar') }}
                </flux:label>
                
                <flux:input 
                    type="file" 
                    wire:model="avatar" 
                    accept="image/*"
                    class="mt-2"
                />
                
                <flux:error name="avatar" />
            </flux:field>

            {{-- Upload Progress --}}
            @if ($uploading)
                <div class="flex items-center gap-2 text-sm text-blue-600 dark:text-blue-400">
                    <div class="w-4 h-4 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                    <span>{{ __('Uploading...') }}</span>
                </div>
            @endif

            {{-- Preview --}}
            @if ($avatar && in_array($avatar->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img 
                            src="{{ $avatar->temporaryUrl() }}" 
                            alt="{{ __('Preview') }}" 
                            class="w-16 h-16 rounded-full object-cover border-2 border-blue-200 dark:border-blue-700"
                        >
                    </div>
                    <div>
                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                            {{ __('Preview') }}
                        </p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            {{ $avatar->getClientOriginalName() }}
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <x-ui.separator />

        {{-- Actions --}}
        @if (auth()->user()->avatar)
            <div>
                <flux:button 
                    wire:click="removeAvatar" 
                    variant="danger"
                    size="sm"
                    wire:confirm="{{ __('Are you sure you want to remove your avatar?') }}"
                    class="cursor-pointer"
                >
                    <span class="flex items-center gap-2">
                        <flux:icon.trash class="w-4 h-4" />
                        {{ __('Remove Avatar') }}
                    </span>
                </flux:button>
            </div>
        @endif

        {{-- Tips --}}
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <h4 class="text-sm font-medium text-blue-900 dark:text-blue-300 mb-2">
                💡 {{ __('Tips for best results') }}
            </h4>
            <ul class="space-y-1 text-sm text-blue-800 dark:text-blue-400">
                <li class="flex items-start gap-2">
                    <span class="text-blue-500 mt-0.5">•</span>
                    <span>{{ __('Optimal size: 400x400 pixels or larger for clarity') }}</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-500 mt-0.5">•</span>
                    <span>{{ __('Use square images for best display') }}</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-500 mt-0.5">•</span>
                    <span>{{ __('Without an avatar, your Gravatar will be used') }}</span>
                </li>
            </ul>
        </div>
    </div>
</div>