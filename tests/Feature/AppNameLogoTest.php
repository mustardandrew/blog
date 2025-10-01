<?php

test('logo uses app name from config', function () {
    config(['app.name' => 'TestBlog']);

    $response = $this->get('/');

    $response->assertSuccessful()
        ->assertSee('TestBlog');
});

test('logo displays book icon svg', function () {
    $response = $this->get('/');

    $response->assertSuccessful()
        ->assertSee('<svg', false)
        ->assertSee('viewBox="0 0 32 32"', false)
        ->assertSee('#6366f1', false) // Book spine color
        ->assertSee('#f59e0b', false); // Accent color
});

test('app name is correctly set to LitBlog', function () {
    expect(config('app.name'))->toBe('LitBlog');
});

test('logo components render with dynamic app name', function () {
    config(['app.name' => 'DynamicName']);

    $logoComponent = view('components.logo')->render();
    $compactComponent = view('components.logo-compact')->render();

    expect($logoComponent)->toContain('DynamicName');
    expect($compactComponent)->toContain('DynamicName');
});
