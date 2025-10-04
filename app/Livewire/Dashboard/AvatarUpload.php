<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class AvatarUpload extends Component
{
    use WithFileUploads;

    public $avatar;
    public $currentAvatar;

    protected $rules = [
        'avatar' => 'required|image|mimes:jpeg,jpg,png,gif,webp|max:2048', // 2MB max
    ];

    protected $messages = [
        'avatar.required' => 'Оберіть файл для завантаження',
        'avatar.image' => 'Файл має бути зображенням',
        'avatar.mimes' => 'Дозволені формати: JPEG, JPG, PNG, GIF, WebP',
        'avatar.max' => 'Розмір файлу не може перевищувати 2 МБ',
    ];

    public function mount(): void
    {
        $this->currentAvatar = Auth::user()->avatar;
    }

    public function updatedAvatar(): void
    {
        $this->validateOnly('avatar');
    }

    public function upload(): void
    {
        $this->validate();

        $user = Auth::user();

        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // Store new avatar
        $avatarPath = $this->avatar->store('avatars', 'public');

        // Update user
        $user->update(['avatar' => $avatarPath]);

        // Update component state
        $this->currentAvatar = $avatarPath;
        $this->avatar = null;

        session()->flash('message', 'Аватар успішно оновлено!');
    }

    public function removeAvatar(): void
    {
        $user = Auth::user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
            $this->currentAvatar = null;

            session()->flash('message', 'Аватар видалено!');
        }
    }

    public function render()
    {
        return view('livewire.dashboard.avatar-upload');
    }
}
