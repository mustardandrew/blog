<?php

declare(strict_types=1);

use App\Models\Contact;
use Livewire\Livewire;

test('contact page loads successfully', function () {
    $response = $this->get(route('contact'));

    $response->assertOk()
        ->assertViewIs('pages.contact.index')
        ->assertSeeLivewire('contact-form');
});

test('contact form can be submitted with valid data', function () {
    Livewire::test('contact-form')
        ->set('name', $name = 'John Doe')
        ->set('email', $email = 'john@example.com')
        ->set('subject', $subject = 'Test Subject')
        ->set('message', $message = 'This is a test message with more than 10 characters.')
        ->call('submit')
        ->assertHasNoErrors()
        ->assertSet('submitted', true);

    $contact = Contact::latest()->first();
    expect($contact)->not->toBeNull();
    expect($contact->name)->toBe($name);
    expect($contact->email)->toBe($email);
    expect($contact->subject)->toBe($subject);
    expect($contact->message)->toBe($message);
    expect($contact->ip_address)->not->toBeNull();
    expect($contact->user_agent)->not->toBeNull();
    expect($contact->is_read)->toBeFalse();
});

test('contact form validates required fields', function () {
    Livewire::test('contact-form')
        ->call('submit')
        ->assertHasErrors(['name', 'email', 'subject', 'message']);
});

test('contact form validates email format', function () {
    Livewire::test('contact-form')
        ->set('name', 'John Doe')
        ->set('email', 'invalid-email')
        ->set('subject', 'Test Subject')
        ->set('message', 'Valid message content.')
        ->call('submit')
        ->assertHasErrors(['email']);
});

test('contact form validates message minimum length', function () {
    Livewire::test('contact-form')
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->set('subject', 'Test Subject')
        ->set('message', 'Short')
        ->call('submit')
        ->assertHasErrors(['message']);
});

test('contact form shows success message after submission', function () {
    $component = Livewire::test('contact-form')
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
        'name' => $name = 'Test User',
        'email' => $email = 'test@example.com',
        'subject' => $subject = 'Test Subject',
        'message' => $message = 'Test message content',
        'is_read' => false,
        'read_at' => null,
    ]);

    expect($contact->name)->toBe($name);
    expect($contact->email)->toBe($email);
    expect($contact->subject)->toBe($subject);
    expect($contact->message)->toBe($message);
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
