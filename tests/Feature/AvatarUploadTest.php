<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

test('dashboard avatar page loads correctly', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
         ->get(route('settings.avatar'))
         ->assertOk()
         ->assertSeeLivewire('dashboard.avatar-upload');
});

test('dashboard avatar page requires authentication', function () {
    $this->get(route('settings.avatar'))
         ->assertRedirect(route('login'));
});

test('avatar upload component renders correctly', function () {
    $user = User::factory()->create(['avatar' => null]);

    $this->actingAs($user);

    Livewire::test(\App\Livewire\Dashboard\AvatarUpload::class)
        ->assertSet('currentAvatar', null)
        ->assertSee(__('Current Avatar'))
        ->assertSee(__('Upload new avatar'));
});

test('user can upload avatar', function () {
    Storage::fake('public');
    
    $user = User::factory()->create(['avatar' => null]);
    $this->actingAs($user);

    $file = UploadedFile::fake()->image('avatar.jpg', 200, 200);

    Livewire::test(\App\Livewire\Dashboard\AvatarUpload::class)
        ->set('avatar', $file)
        ->assertHasNoErrors()
        ->assertSet('currentAvatar', function ($value) {
            return $value !== null && str_contains($value, 'avatars/');
        });

    $user->refresh();
    expect($user->avatar)->not->toBeNull();
    expect(Storage::disk('public')->exists($user->avatar))->toBeTrue();
});

test('avatar upload validates file type', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $file = UploadedFile::fake()->create('document.pdf', 100, 'application/pdf');

    Livewire::test(\App\Livewire\Dashboard\AvatarUpload::class)
        ->set('avatar', $file)
        ->assertHasErrors(['avatar']);
});

test('avatar upload validates file size', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    // Create a file larger than 2MB
    $file = UploadedFile::fake()->image('large-avatar.jpg')->size(3000);

    Livewire::test(\App\Livewire\Dashboard\AvatarUpload::class)
        ->set('avatar', $file)
        ->call('upload')
        ->assertHasErrors(['avatar' => 'max']);
});

test('user can remove avatar', function () {
    Storage::fake('public');
    
    // Create user with existing avatar
    $avatarPath = 'avatars/test-avatar.jpg';
    Storage::disk('public')->put($avatarPath, 'fake image content');
    
    $user = User::factory()->create(['avatar' => $avatarPath]);
    $this->actingAs($user);

    Livewire::test(\App\Livewire\Dashboard\AvatarUpload::class)
        ->call('removeAvatar')
        ->assertSet('currentAvatar', null);

    $user->refresh();
    expect($user->avatar)->toBeNull();
    expect(Storage::disk('public')->exists($avatarPath))->toBeFalse();
});

test('removing non-existent avatar does nothing', function () {
    $user = User::factory()->create(['avatar' => null]);
    $this->actingAs($user);

    Livewire::test(\App\Livewire\Dashboard\AvatarUpload::class)
        ->call('removeAvatar')
        ->assertHasNoErrors();

    $user->refresh();
    expect($user->avatar)->toBeNull();
});

test('uploading new avatar removes old one', function () {
    Storage::fake('public');
    
    // Create user with existing avatar
    $oldAvatarPath = 'avatars/old-avatar.jpg';
    Storage::disk('public')->put($oldAvatarPath, 'old avatar content');
    
    $user = User::factory()->create(['avatar' => $oldAvatarPath]);
    $this->actingAs($user);

    $newFile = UploadedFile::fake()->image('new-avatar.jpg', 200, 200);

    Livewire::test(\App\Livewire\Dashboard\AvatarUpload::class)
        ->set('avatar', $newFile)
        ->assertHasNoErrors();

    $user->refresh();
    expect($user->avatar)->not->toBe($oldAvatarPath);
    expect(Storage::disk('public')->exists($oldAvatarPath))->toBeFalse();
    expect(Storage::disk('public')->exists($user->avatar))->toBeTrue();
});

test('avatar link appears in dashboard sidebar', function () {
    $user = User::factory()->create();

    $this->actingAs($user)
         ->get('/dashboard')
         ->assertSee('Аватар')
         ->assertSee(route('settings.avatar'));
});
