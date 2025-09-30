<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Volt\Volt;

uses(RefreshDatabase::class);

test('user avatar component renders correctly', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'avatar' => 'avatars/test-avatar.jpg',
    ]);

    Volt::test('components.user-avatar', ['user' => $user])
        ->assertSee('John Doe')
        ->assertSee('test-avatar.jpg')
        ->assertSeeHtml('alt="John Doe\'s avatar"');
});

test('user avatar component works with different sizes', function () {
    $user = User::factory()->create();

    Volt::test('components.user-avatar', ['user' => $user, 'size' => 'lg'])
        ->assertSeeHtml('w-12 h-12');

    Volt::test('components.user-avatar', ['user' => $user, 'size' => 'sm'])
        ->assertSeeHtml('w-8 h-8');
});

test('user avatar component shows name when requested', function () {
    $user = User::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    Volt::test('components.user-avatar', ['user' => $user, 'showName' => true])
        ->assertSee('Jane Smith')
        ->assertSee('jane@example.com');
});

test('user avatar component hides name by default', function () {
    $user = User::factory()->create([
        'name' => 'Hidden Name',
        'email' => 'hidden@example.com',
    ]);

    $component = Volt::test('components.user-avatar', ['user' => $user]);
    
    // Перевіряємо, що ім'я не відображається як текст (не в alt атрибуті)
    expect($component->html())
        ->not->toContain('font-medium') // CSS клас для імені
        ->not->toContain('hidden@example.com'); // Email не повинен бути видимим
});

test('user avatar uses gravatar when no avatar uploaded', function () {
    $user = User::factory()->create([
        'email' => 'gravatar@example.com',
        'avatar' => null,
    ]);

    Volt::test('components.user-avatar', ['user' => $user])
        ->assertSeeHtml('gravatar.com');
});
