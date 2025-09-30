<?php

use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get(route('dashboard'));
    $response->assertRedirect(route('login'));
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    $response->assertStatus(200);
});

test('dashboard displays user avatar and information', function () {
    $user = User::factory()->create([
        'name' => 'John Dashboard',
        'email' => 'john@dashboard.com',
    ]);
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    
    $response->assertStatus(200)
        ->assertSee('John Dashboard')
        ->assertSee('john@dashboard.com')
        ->assertSee('Welcome back!');
});

test('dashboard shows admin status for admin users', function () {
    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);

    $response = $this->get(route('dashboard'));
    
    $response->assertStatus(200)
        ->assertSee('Administrator', false); // Частинка тексту без escape
});

test('dashboard shows user status for regular users', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get(route('dashboard'));
    
    $response->assertStatus(200)
        ->assertSee('logged in as a User', false);
});