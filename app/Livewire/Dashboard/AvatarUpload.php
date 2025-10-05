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
    public $user;
    public $temporary_url = null;
    public $uploading = false;
    public $currentAvatar = null;

    protected $rules = [
        'avatar' => 'image|mimes:jpeg,jpg,png,gif,webp|max:2048', // 2MB max
    ];

    protected $messages = [
        'avatar.image' => 'Файл має бути зображенням',
        'avatar.mimes' => 'Дозволені формати: JPEG, JPG, PNG, GIF, WebP',
        'avatar.max' => 'Розмір файлу не може перевищувати 2 МБ',
    ];

    public function mount(): void
    {
        $this->currentAvatar = Auth::user()->avatar;
    }

    public function getAvatarUrlProperty(): string
    {
        return Auth::user()->getAvatarUrl();
    }

    public function updatedAvatar(): void
    {
        if ($this->avatar) {
            $this->uploading = true;
            $this->validateOnly('avatar');
            if (!$this->getErrorBag()->has('avatar')) {
                try {
                    $this->upload();
                } catch (\Exception $e) {
                    $this->addError('avatar', 'Помилка при завантаженні файлу: ' . $e->getMessage());
                } finally {
                    $this->uploading = false;
                }
            } else {
                $this->uploading = false;
            }
        }
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
        $this->temporary_url = null;

        $this->dispatch('avatar-updated');

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
