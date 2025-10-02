<?php

declare(strict_types=1);

use App\Livewire\NewsletterSubscription;
use App\Models\Newsletter;
use App\Models\User;
use Livewire\Livewire;

test('guest can subscribe to newsletter', function () {
    Livewire::test(NewsletterSubscription::class)
        ->set('email', 'test@example.com')
        ->set('name', 'Test User')
        ->call('subscribe')
        ->assertSet('isSubscribed', true)
        ->assertSee('Thank you for subscribing! Please check your email to confirm your subscription.');

    expect(Newsletter::where('email', 'test@example.com')->exists())->toBeTrue();
});

test('authenticated user can subscribe with their email', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(NewsletterSubscription::class)
        ->assertSet('email', $user->email)
        ->assertSet('name', $user->name)
        ->call('subscribe')
        ->assertSet('isSubscribed', true)
        ->assertSee('Thank you for subscribing to our newsletter!');

    expect(Newsletter::where('email', $user->email)->exists())->toBeTrue();
});

test('prevents duplicate subscriptions', function () {
    Newsletter::factory()->create([
        'email' => 'test@example.com',
        'is_active' => true,
    ]);

    Livewire::test(NewsletterSubscription::class)
        ->set('email', 'test@example.com')
        ->call('subscribe')
        ->assertSet('isSubscribed', true)
        ->assertSee('You are already subscribed to our newsletter!');

    expect(Newsletter::where('email', 'test@example.com')->count())->toBe(1);
});

test('validates email field', function () {
    Livewire::test(NewsletterSubscription::class)
        ->set('email', 'invalid-email')
        ->call('subscribe')
        ->assertHasErrors(['email']);
});

test('requires email field', function () {
    Livewire::test(NewsletterSubscription::class)
        ->set('email', '')
        ->call('subscribe')
        ->assertHasErrors(['email']);
});

test('authenticated user email field is readonly', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(NewsletterSubscription::class)
        ->assertSee($user->email);
});

test('guest user sees name field', function () {
    Livewire::test(NewsletterSubscription::class)
        ->assertSee('Your name (optional)');
});

test('authenticated user does not see name field', function () {
    $user = User::factory()->create();

    Livewire::actingAs($user)
        ->test(NewsletterSubscription::class)
        ->assertDontSee('Your name (optional)');
});

test('can reset form after subscription', function () {
    Livewire::test(NewsletterSubscription::class)
        ->set('email', 'test@example.com')
        ->call('subscribe')
        ->assertSet('isSubscribed', true)
        ->call('resetForm')
        ->assertSet('isSubscribed', false)
        ->assertSet('email', '')
        ->assertSet('message', '');
});

test('shows already subscribed message for existing subscriber', function () {
    $user = User::factory()->create();
    Newsletter::factory()->create([
        'email' => $user->email,
        'user_id' => $user->id,
        'is_active' => true,
    ]);

    Livewire::actingAs($user)
        ->test(NewsletterSubscription::class)
        ->assertSet('isSubscribed', true)
        ->assertSee('You are already subscribed to our newsletter!');
});

it('renders successfully', function () {
    Livewire::test(NewsletterSubscription::class)
        ->assertStatus(200);
});
