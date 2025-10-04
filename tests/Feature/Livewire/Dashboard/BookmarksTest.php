<?php

namespace Tests\Feature\Livewire\Dashboard;

use Livewire\Volt\Volt;
use Tests\TestCase;

class BookmarksTest extends TestCase
{
    public function test_it_can_render(): void
    {
        $component = Volt::test('dashboard.bookmarks');

        $component->assertSee('');
    }
}
