<?php

declare(strict_types=1);

use App\Filament\Widgets\UnreadContactsWidget;
use App\Models\Contact;
use App\Models\User;
use Livewire\Livewire;

test('widget is visible when there are unread contacts', function () {
    Contact::factory()->unread()->create();

    expect(UnreadContactsWidget::canView())->toBeTrue();
});

test('widget is hidden when no unread contacts', function () {
    Contact::factory()->read()->create();

    expect(UnreadContactsWidget::canView())->toBeFalse();
});

test('widget shows correct unread count', function () {
    $this->actingAs(User::factory()->admin()->create());

    Contact::factory()->unread()->count(3)->create();
    Contact::factory()->read()->count(2)->create();

    Livewire::test(UnreadContactsWidget::class)
        ->assertSee('3') // Should see unread count
        ->assertSee('new messages'); // Updated text for custom widget
});

test('widget shows recent messages preview', function () {
    $this->actingAs(User::factory()->admin()->create());

    $contact = Contact::factory()->unread()->create([
        'name' => 'John Doe',
        'subject' => 'Test Subject for Widget',
    ]);

    Livewire::test(UnreadContactsWidget::class)
        ->assertSee('John Doe')
        ->assertSee('Test Subject for Widget');
});

test('widget polls for updates', function () {
    $this->actingAs(User::factory()->admin()->create());

    Contact::factory()->unread()->create();

    $widget = Livewire::test(UnreadContactsWidget::class);

    expect($widget->instance()->getPollingInterval())->toBe('30s');
});

test('widget shows today contacts when available', function () {
    $this->actingAs(User::factory()->admin()->create());

    // Create an unread contact for today
    Contact::factory()->unread()->create([
        'created_at' => now(),
    ]);

    // Create an old unread contact
    Contact::factory()->unread()->create([
        'created_at' => now()->subDays(5),
    ]);

    Livewire::test(UnreadContactsWidget::class)
        ->assertSee('Today') // Updated to match new widget text
        ->assertSee('1'); // Should show 1 for today's count
});

test('widget shows total contacts count', function () {
    $this->actingAs(User::factory()->admin()->create());

    Contact::factory()->unread()->count(2)->create();
    Contact::factory()->read()->count(3)->create();

    Livewire::test(UnreadContactsWidget::class)
        ->assertSee('5') // Total count
        ->assertSee('Total');
});

test('widget displays recent message content preview', function () {
    $this->actingAs(User::factory()->admin()->create());

    Contact::factory()->unread()->create([
        'name' => 'Jane Smith',
        'subject' => 'Urgent inquiry about services',
        'message' => 'I need more information about your pricing and availability for next month.',
    ]);

    Livewire::test(UnreadContactsWidget::class)
        ->assertSee('Jane Smith')
        ->assertSee('Urgent inquiry about services')
        ->assertSee('I need more information about your pricing');
});
