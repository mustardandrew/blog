<div>
    <!-- Flash Messages -->
    @if (session()->has('message'))
        <div class="mb-6">
            <flux:callout variant="success" icon="check-circle">{{ session('message') }}</flux:callout>
        </div>
    @endif

    <!-- Current Avatar Section -->
    <div class="mb-8">
        <flux:heading size="lg" class="mb-4">Поточний аватар</flux:heading>
        <div class="flex items-center gap-6">
            <div class="relative">
                <img 
                    src="{{ auth()->user()->getAvatarUrl() }}" 
                    alt="Поточний аватар"
                    class="w-24 h-24 rounded-full object-cover border-4 border-zinc-200 dark:border-zinc-700"
                >
                @if($currentAvatar)
                    <flux:button 
                        variant="danger" 
                        size="sm"
                        wire:click="removeAvatar"
                        wire:confirm="Видалити поточний аватар?"
                        class="absolute -top-2 -right-2 w-8 h-8 rounded-full p-0 flex items-center justify-center"
                        title="Видалити аватар"
                    >
                        <flux:icon name="x-mark" class="w-4 h-4" />
                    </flux:button>
                @endif
            </div>
            <div>
                <flux:text class="text-zinc-600 dark:text-zinc-400 mb-2">
                    @if($currentAvatar)
                        Ваш персональний аватар
                    @else
                        Використовується Gravatar за замовчуванням
                    @endif
                </flux:text>
                <flux:text size="sm" class="text-zinc-500">
                    Рекомендований розмір: 200x200 пікселів
                </flux:text>
            </div>
        </div>
    </div>

    <!-- Upload Form -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl border border-zinc-200 dark:border-zinc-700 p-6">
        <flux:heading size="lg" class="mb-6">Завантажити новий аватар</flux:heading>
        
        <form wire:submit="upload" class="space-y-6">
            <!-- File Upload -->
            <div>
                <flux:field>
                    <flux:label>Оберіть зображення</flux:label>
                    <flux:input 
                        type="file" 
                        wire:model="avatar"
                        accept="image/*"
                        class="file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100"
                    />
                    <flux:description>
                        Формати: JPEG, JPG, PNG, GIF, WebP. Максимальний розмір: 2 МБ
                    </flux:description>
                    @error('avatar')
                        <flux:error>{{ $message }}</flux:error>
                    @enderror
                </flux:field>
            </div>

            <!-- Preview -->
            @if ($avatar)
                <div>
                    <flux:text class="block mb-3 font-medium">Попередній перегляд:</flux:text>
                    <div class="flex items-center gap-4">
                        <img 
                            src="{{ $avatar->temporaryUrl() }}" 
                            alt="Попередній перегляд"
                            class="w-16 h-16 rounded-full object-cover border-2 border-zinc-200 dark:border-zinc-700"
                        >
                        <div>
                            <flux:text size="sm" class="text-zinc-600 dark:text-zinc-400">
                                {{ $avatar->getClientOriginalName() }}
                            </flux:text>
                            <flux:text size="sm" class="text-zinc-500">
                                {{ number_format($avatar->getSize() / 1024, 1) }} КБ
                            </flux:text>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Upload Button -->
            <div class="flex items-center gap-3">
                <flux:button 
                    type="submit" 
                    variant="primary"
                    :disabled="!$avatar"
                    wire:loading.attr="disabled"
                    wire:target="upload"
                >
                    <span wire:loading.remove wire:target="upload">
                        <flux:icon name="cloud-arrow-up" class="w-4 h-4 mr-2" />
                        Завантажити аватар
                    </span>
                    <span wire:loading wire:target="upload" class="flex items-center">
                        <div class="animate-spin w-4 h-4 border-2 border-white border-t-transparent rounded-full mr-2"></div>
                        Завантаження...
                    </span>
                </flux:button>

                @if($avatar)
                    <flux:button 
                        type="button"
                        variant="subtle"
                        wire:click="$set('avatar', null)"
                    >
                        Скасувати
                    </flux:button>
                @endif
            </div>
        </form>
    </div>

    <!-- Loading States -->
    <div wire:loading.flex wire:target="removeAvatar" class="fixed inset-0 bg-black/20 items-center justify-center z-50">
        <div class="bg-white dark:bg-zinc-800 rounded-lg p-6 flex items-center gap-3">
            <div class="animate-spin w-5 h-5 border-2 border-zinc-300 border-t-zinc-600 rounded-full"></div>
            <flux:text>Видалення аватара...</flux:text>
        </div>
    </div>

    <!-- Usage Tips -->
    <div class="mt-8 bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
        <flux:heading size="sm" class="mb-3 text-blue-900 dark:text-blue-100">
            <flux:icon name="light-bulb" class="w-4 h-4 mr-2 inline" />
            Поради
        </flux:heading>
        <ul class="space-y-1 text-sm text-blue-800 dark:text-blue-200">
            <li>• Використовуйте квадратні зображення для кращого результату</li>
            <li>• Оптимальний розмір: 200x200 пікселів або більше</li>
            <li>• Зображення буде автоматично обрізане до кругової форми</li>
            <li>• Якщо не завантажите аватар, буде використано Gravatar</li>
        </ul>
    </div>
</div>
