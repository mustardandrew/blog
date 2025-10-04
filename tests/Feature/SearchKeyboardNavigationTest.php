<?php

declare(strict_types=1);

use App\Models\{Post, User};
use Livewire\Volt\Volt;

beforeEach(function () {
    $this->user = User::factory()->create();
    
    $this->posts = Post::factory()
        ->published()
        ->for($this->user)
        ->count(5)
        ->sequence(
            ['title' => 'Laravel Tutorial', 'excerpt' => 'Learn Laravel basics'],
            ['title' => 'PHP Best Practices', 'excerpt' => 'How to write better PHP code'],
            ['title' => 'Vue.js Guide', 'excerpt' => 'Frontend development with Vue'],
            ['title' => 'Database Design', 'excerpt' => 'Designing efficient databases'],
            ['title' => 'API Development', 'excerpt' => 'Building REST APIs']
        )
        ->create();
});

test('search panel shows keyboard navigation hints', function () {
    Volt::test('search-panel')
        ->set('isOpen', true)
        ->set('query', 'Laravel')
        ->assertSee('Laravel Tutorial')
        ->assertSeeHtml('data-result-index="0"');
});

test('search panel has proper Alpine.js data structure', function () {
    Volt::test('search-panel')
        ->set('isOpen', true)
        ->assertSeeHtml('selectedIndex: -1')
        ->assertSeeHtml('selectNext()')
        ->assertSeeHtml('selectPrevious()')
        ->assertSeeHtml('openSelected()');
});

test('search results have correct index attributes', function () {
    Volt::test('search-panel')
        ->set('isOpen', true)
        ->set('query', 'Tutorial')
        ->assertSeeHtml('data-result-index="0"')
        ->assertSeeHtml('@mouseenter="selectedIndex = 0"')
        ->assertSeeHtml('@mouseleave="selectedIndex = -1"');
});

test('search panel keyboard events are properly bound', function () {
    Volt::test('search-panel')
        ->set('isOpen', true)
        ->assertSeeHtml('@keydown.arrow-down.prevent="selectNext()"')
        ->assertSeeHtml('@keydown.arrow-up.prevent="selectPrevious()"')
        ->assertSeeHtml('@keydown.enter.prevent="openSelected()"')
        ->assertSeeHtml('@keydown.escape="$wire.closeSearch()"')
        ->assertSeeHtml('@input="resetSelection()"');
});

test('search results have selection highlighting classes', function () {
    Volt::test('search-panel')
        ->set('isOpen', true)
        ->set('query', 'Laravel')
        ->assertSeeHtml("'bg-blue-50 dark:bg-blue-900/20 border-blue-200 dark:border-blue-800': selectedIndex === 0");
});

test('search panel has results container reference', function () {
    Volt::test('search-panel')
        ->set('isOpen', true)
        ->assertSeeHtml('x-ref="resultsContainer"');
});