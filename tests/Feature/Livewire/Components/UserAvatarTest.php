<?php

namespace Tests\Feature\Livewire\Components;

use Livewire\Livewire;
use Tests\TestCase;

class UserAvatarTest extends TestCase
{
    public function test_it_can_render(): void
    {
        $component = Livewire::test('components.user-avatar');

        $component->assertSee('');
    }
}
