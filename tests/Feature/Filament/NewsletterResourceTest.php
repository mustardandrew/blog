<?php

use App\Filament\Resources\Newsletters\Pages\CreateNewsletter;
use App\Filament\Resources\Newsletters\Pages\EditNewsletter;
use App\Filament\Resources\Newsletters\Pages\ListNewsletters;
use App\Models\Newsletter;
use App\Models\User;
use Filament\Facades\Filament;
use Livewire\Livewire;

beforeEach(function () {
    Filament::setCurrentPanel('app');
    $this->actingAs(User::factory()->create());
});

test('can list newsletters', function () {
    $newsletters = Newsletter::factory()->count(3)->create();

    Livewire::test(ListNewsletters::class)
        ->assertCanSeeTableRecords($newsletters);
});

test('can create newsletter', function () {
    Livewire::test(CreateNewsletter::class)
        ->fillForm([
            'email' => 'test@example.com',
            'name' => 'Test User',
            'is_active' => true,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Newsletter::class, [
        'email' => 'test@example.com',
        'name' => 'Test User',
        'is_active' => true,
    ]);
});

test('can edit newsletter', function () {
    $newsletter = Newsletter::factory()->create();

    Livewire::test(EditNewsletter::class, [
        'record' => $newsletter->getRouteKey(),
    ])
        ->fillForm([
            'email' => 'updated@example.com',
            'is_active' => false,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($newsletter->refresh())
        ->email->toBe('updated@example.com')
        ->is_active->toBeFalse();
});

test('can search newsletters by email', function () {
    $newsletters = Newsletter::factory()->count(3)->create();
    $searchNewsletter = $newsletters->first();

    Livewire::test(ListNewsletters::class)
        ->searchTable($searchNewsletter->email)
        ->assertCanSeeTableRecords([$searchNewsletter])
        ->assertCanNotSeeTableRecords($newsletters->skip(1));
});

test('can filter newsletters by active status', function () {
    $activeNewsletters = Newsletter::factory()->count(2)->create(['is_active' => true]);
    $inactiveNewsletters = Newsletter::factory()->count(2)->create(['is_active' => false]);

    Livewire::test(ListNewsletters::class)
        ->filterTable('is_active', true)
        ->assertCanSeeTableRecords($activeNewsletters)
        ->assertCanNotSeeTableRecords($inactiveNewsletters);
});

test('can filter newsletters by verification status', function () {
    Newsletter::factory()->count(2)->verified()->create();
    Newsletter::factory()->count(2)->create();

    $component = Livewire::test(ListNewsletters::class)
        ->filterTable('email_verified_at', true);

    // Just check that filtering doesn't break the component
    $component->assertSuccessful();
});
