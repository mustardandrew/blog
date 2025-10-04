<?php

declare(strict_types=1);

test('search button is present in header', function () {
    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('id="search-button"', false)
        ->assertSee('aria-label="Search"', false);
});

test('search panel component is included in layout', function () {
    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSeeLivewire('search-panel');
});

test('search button has proper JavaScript function', function () {
    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee('openSearchPanel()', false)
        ->assertSee('initializeSearchPanel', false);
});

test('keyboard shortcut script is included', function () {
    $response = $this->get('/');

    $response->assertStatus(200)
        ->assertSee("e.key === 'k'", false)
        ->assertSee('e.ctrlKey || e.metaKey', false);
});
