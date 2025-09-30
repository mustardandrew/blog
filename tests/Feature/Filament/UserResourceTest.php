<?php

declare(strict_types=1);

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->admin = User::factory()->admin()->create();
    $this->actingAs($this->admin);
});

test('admin can view users list', function () {
    $users = User::factory(3)->create();

    Livewire::test(ListUsers::class)
        ->assertCanSeeTableRecords($users)
        ->assertSuccessful();
});

test('admin can create a new user', function () {
    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password123',
            'is_admin' => false,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('users', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'is_admin' => false,
    ]);
});

test('admin can create an admin user', function () {
    Livewire::test(CreateUser::class)
        ->fillForm([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password123',
            'is_admin' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas('users', [
        'name' => 'Admin User',
        'email' => 'admin@example.com',
        'is_admin' => true,
    ]);
});

test('admin can edit a user', function () {
    $user = User::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@example.com',
    ]);

    Livewire::test(EditUser::class, ['record' => $user->id])
        ->fillForm([
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'is_admin' => true,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    $user->refresh();
    
    expect($user->name)->toBe('Updated Name')
        ->and($user->email)->toBe('updated@example.com')
        ->and($user->is_admin)->toBeTrue();
});

test('admin can filter users by admin status', function () {
    $adminUsers = User::factory(2)->admin()->create();
    $regularUsers = User::factory(3)->create();

    Livewire::test(ListUsers::class)
        ->filterTable('admins')
        ->assertCanSeeTableRecords($adminUsers)
        ->assertCanNotSeeTableRecords($regularUsers);
});

test('admin can search users by name', function () {
    $user1 = User::factory()->create(['name' => 'John Doe']);
    $user2 = User::factory()->create(['name' => 'Jane Smith']);

    Livewire::test(ListUsers::class)
        ->searchTable('John')
        ->assertCanSeeTableRecords([$user1])
        ->assertCanNotSeeTableRecords([$user2]);
});

test('admin can search users by email', function () {
    $user1 = User::factory()->create(['email' => 'john@example.com']);
    $user2 = User::factory()->create(['email' => 'jane@example.com']);

    Livewire::test(ListUsers::class)
        ->searchTable('john@example.com')
        ->assertCanSeeTableRecords([$user1])
        ->assertCanNotSeeTableRecords([$user2]);
});

test('user avatar displays correctly', function () {
    $user = User::factory()->create([
        'name' => 'Avatar User',
        'email' => 'avatar@example.com',
        'avatar' => 'avatars/test-avatar.jpg',
    ]);

    expect($user->getAvatarUrl())->toContain('test-avatar.jpg');
});

test('user without avatar uses gravatar', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'avatar' => null,
    ]);

    $avatarUrl = $user->getAvatarUrl();
    expect($avatarUrl)->toContain('gravatar.com')
        ->and($avatarUrl)->toContain(md5('test@example.com'));
});
