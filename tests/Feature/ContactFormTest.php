<?php

declare(strict_types=1);

use App\Models\Contact;
use Livewire\Volt\Volt;

test('contact page loads successfully', function () {
    $response = $this->get(route('contact'));

    $response->assertOk()
        ->assertViewIs('contact.index')
        ->assertSee('Get In Touch')
        ->assertSee('Send us a message');
});

test('contact form can be submitted with valid data', function () {
    Volt::test('contact-form')
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a test message with more than 10 characters.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    $contact = Contact::latest()->first();
    expect($contact)->not->toBeNull();
    expect($contact->name)->toBe('John Doe');
    expect($contact->email)->toBe('john@example.com');
    expect($contact->subject)->toBe('Test Subject');
    expect($contact->message)->toBe('This is a test message with more than 10 characters.');
    expect($contact->ip_address)->not->toBeNull();
    expect($contact->user_agent)->not->toBeNull();
    expect($contact->is_read)->toBeFalse();
});

test('contact form validates required fields', function () {
    Volt::test('contact-form')
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'subject', 'message']);
});

test('contact form validates email format', function () {
    Volt::test('contact-form')
        ->set('name', 'John Doe')
        ->set('email', 'invalid-email')
        ->set('subject', 'Test Subject')
        ->set('message', 'Valid message content.')
        ->call('submit')
        ->assertHasErrors(['email']);
});

test('contact form validates message minimum length', function () {
    Volt::test('contact-form')
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'Short')
        ->call('submit')
        ->assertHasErrors(['message']);
});

test('contact form shows success message after submission', function () {
    $component = Volt::test('contact-form')
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'This is a valid test message.')
        ->call('submit');

    // Check that form was reset and submitted flag is true
    $component->assertSet('submitted', true)
        ->assertSet('name', '')
        ->assertSet('email', '')
        ->assertSet('subject', '')
        ->assertSet('message', '');

    // Check that a contact was created
    expect(Contact::count())->toBe(1);
});

test('contact model has correct attributes', function () {
    $contact = Contact::factory()->create([
        'name' => 'Test User',
        'email' => 'test@example.com',
        'subject' => 'Test Subject',
        'message' => 'Test message content',
        'is_read' => false,
    ]);

    expect($contact->name)->toBe('Test User');
    expect($contact->email)->toBe('test@example.com');
    expect($contact->subject)->toBe('Test Subject');
    expect($contact->message)->toBe('Test message content');
    expect($contact->is_read)->toBeFalse();
    expect($contact->read_at)->toBeNull();
});

test('contact can be marked as read', function () {
    $contact = Contact::factory()->unread()->create();

    expect($contact->is_read)->toBeFalse();
    expect($contact->read_at)->toBeNull();

    $contact->markAsRead();

    expect($contact->fresh()->is_read)->toBeTrue();
    expect($contact->fresh()->read_at)->not->toBeNull();
});

test('contact scopes work correctly', function () {
    Contact::factory()->read()->count(3)->create();
    Contact::factory()->unread()->count(2)->create();

    expect(Contact::read()->count())->toBe(3);
    expect(Contact::unread()->count())->toBe(2);
});
