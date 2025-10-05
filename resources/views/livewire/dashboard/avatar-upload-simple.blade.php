<div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 shadow-sm">
    {{-- Success/Error Messages --}}
    @if (session()->has('message'))
        <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
            <p class="text-green-800 dark:text-green-300 text-sm font-medium">
                {{ session('message') }}
            </p>
        </div>
    @endif

    @if (session()->has('error'))
        <div class="mb-6 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg">
            <p class="text-red-800 dark:text-red-300 text-sm font-medium">
                {{ session('error') }}
            </p>
        </div>
    @endif

    <div class="space-y-6">
        {{-- Header --}}
        <div>
            <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Аватар користувача dssd</h2>
            <p class="mt-1 text-sm text-zinc-600 dark:text-zinc-400">
                Оновіть свій аватар або залиште поле порожнім для використання Gravatar
            </p>
        </div>

        {{-- Current Avatar Display --}}
        <div class="flex items-center gap-6">
            <div class="relative">
                <img 
                    src="{{ $this->avatarUrl }}" 
                    alt="Поточний аватар" 
                    class="w-20 h-20 rounded-full object-cover border-2 border-zinc-200 dark:border-zinc-700"
                >
            </div>
            
            <div class="flex-1">
                <h3 class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Поточний аватар</h3>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">
                    Підтримуються формати: JPEG, PNG, GIF, WebP (до 10MB)
                </p>
            </div>
        </div>

        {{-- Upload Form --}}
        <div class="space-y-4">
            <flux:field>
                <flux:label class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                    Завантажити новий аватар
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
                    <span>Завантаження...</span>
                </div>
            @endif

            {{-- Preview --}}
            @if ($avatar)
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <img 
                            src="{{ $avatar->temporaryUrl() }}" 
                            alt="Попередній перегляд" 
                            class="w-16 h-16 rounded-full object-cover border-2 border-blue-200 dark:border-blue-700"
                        >
                    </div>
                    <div>
                        <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">
                            Попередній перегляд
                        </p>
                        <p class="text-xs text-zinc-500 dark:text-zinc-400">
                            {{ $avatar->getClientOriginalName() }}
                        </p>
                    </div>
                </div>
            @endif
        </div>

        {{-- Actions --}}
        @if (auth()->user()->avatar)
            <div class="pt-4 border-t border-zinc-200 dark:border-zinc-700">
                <flux:button 
                    wire:click="removeAvatar" 
                    variant="danger"
                    size="sm"
                    wire:confirm="Ви впевнені, що хочете видалити аватар?"
                >
                    <flux:icon.trash class="w-4 h-4" />
                    Видалити аватар
                </flux:button>
            </div>
        @endif

        {{-- Tips --}}
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <h4 class="text-sm font-medium text-blue-900 dark:text-blue-300 mb-2">
                💡 Поради для кращого результату
            </h4>
            <ul class="space-y-1 text-sm text-blue-800 dark:text-blue-400">
                <li class="flex items-start gap-2">
                    <span class="text-blue-500 mt-0.5">•</span>
                    <span>Оптимальний розмір: 400x400 пікселів або більше для чіткості</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-500 mt-0.5">•</span>
                    <span>Використовуйте квадратні зображення для найкращого відображення</span>
                </li>
                <li class="flex items-start gap-2">
                    <span class="text-blue-500 mt-0.5">•</span>
                    <span>Без аватара використовується ваш Gravatar</span>
                </li>
            </ul>
        </div>
    </div>
</div>