<?php

use App\Models\User;
use Livewire\Volt\Component;

new class extends Component {
    public User $user;
    public string $size = 'md';
    public bool $showName = false;

    public function mount(User $user, string $size = 'md', bool $showName = false): void
    {
        $this->user = $user;
        $this->size = $size;
        $this->showName = $showName;
    }

    public function getSizeClasses(): string
    {
        return match($this->size) {
            'xs' => 'w-6 h-6',
            'sm' => 'w-8 h-8', 
            'md' => 'w-10 h-10',
            'lg' => 'w-12 h-12',
            'xl' => 'w-16 h-16',
            '2xl' => 'w-20 h-20',
            default => 'w-10 h-10',
        };
    }

    public function getTextSizeClasses(): string
    {
        return match($this->size) {
            'xs' => 'text-xs',
            'sm' => 'text-sm', 
            'md' => 'text-base',
            'lg' => 'text-lg',
            'xl' => 'text-xl',
            '2xl' => 'text-2xl',
            default => 'text-base',
        };
    }
}; ?>

<div class="flex items-center space-x-3">
    <div class="relative {{ $this->getSizeClasses() }} bg-gray-100 rounded-full overflow-hidden">
        <img 
            src="{{ $user->getAvatarUrl() }}" 
            alt="{{ $user->name }}'s avatar"
            class="w-full h-full object-cover"
            loading="lazy"
        >
    </div>
    
    @if($showName)
        <div class="flex flex-col">
            <span class="font-medium text-gray-900 dark:text-gray-100 {{ $this->getTextSizeClasses() }}">
                {{ $user->name }}
            </span>
            <span class="text-gray-500 dark:text-gray-400 text-sm">
                {{ $user->email }}
            </span>
        </div>
    @endif
</div>
