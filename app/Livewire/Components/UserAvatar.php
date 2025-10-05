<?php

namespace App\Livewire\Components;

use App\Models\User;
use Livewire\Component;

class UserAvatar extends Component {
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

    public function render()
    {
        return view('livewire.components.user-avatar');
    }
}