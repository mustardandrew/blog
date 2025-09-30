<?php

namespace Tests\Feature\Livewire\Components;

use Livewire\Volt\Volt;
use Tests\TestCase;

class UserAvatarTest extends TestCase
{
    public function test_it_can_render(): void
    {
        $component = Volt::test('components.user-avatar');

        $component->assertSee('');
    }
}
