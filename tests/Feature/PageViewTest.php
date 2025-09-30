<?php

declare(strict_types=1);

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests can view published pages', function () {
    $page = Page::factory()->published()->create();

    $response = $this->get(route('pages.show', $page->slug));

    $response->assertStatus(200)
        ->assertSee($page->title)
        ->assertSee($page->content, false);
});

test('guests cannot view draft pages', function () {
    $draftPage = Page::factory()->draft()->create();

    $response = $this->get(route('pages.show', $draftPage->slug));
    $response->assertStatus(404);
});

test('guests cannot view scheduled pages', function () {
    $scheduledPage = Page::factory()->scheduled()->create();

    $response = $this->get(route('pages.show', $scheduledPage->slug));
    $response->assertStatus(404);
});

test('admin can view draft pages', function () {
    $admin = User::factory()->admin()->create();
    $this->actingAs($admin);

    $page = Page::factory()->draft()->create([
        'title' => 'Admin Draft Page',
        'slug' => 'admin-draft-page',
        'content' => 'Admin can see this',
    ]);

    $response = $this->get(route('pages.show', $page->slug));

    $response->assertStatus(200)
        ->assertSee('Admin Draft Page')
        ->assertSee('Admin can see this')
        ->assertSee('Admin Tools');
});

test('regular user cannot view draft pages', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $page = Page::factory()->draft()->create([
        'slug' => 'user-draft-page',
    ]);

    $response = $this->get(route('pages.show', $page->slug));

    $response->assertStatus(404);
});

test('page displays author information', function () {
    $user = User::factory()->create();
    $this->actingAs($user);
    
    $author = User::factory()->create(['name' => 'Jane Author']);
    $page = Page::factory()->published()->create([
        'author_id' => $author->id,
        'title' => 'Page with Author',
    ]);

    $response = $this->get(route('pages.show', $page->slug));

    $response->assertStatus(200)
        ->assertSee('Jane Author');
});

test('page displays published date', function () {
    $publishedDate = now()->subDays(5);
    $page = Page::factory()->published()->create([
        'published_at' => $publishedDate,
    ]);

    $response = $this->get(route('pages.show', $page->slug));

    $response->assertStatus(200)
        ->assertSee($publishedDate->format('F j, Y'));
});

test('page displays excerpt when available', function () {
    $page = Page::factory()->published()->create([
        'title' => 'Page with Excerpt',
        'excerpt' => 'This is a test excerpt',
    ]);

    $response = $this->get(route('pages.show', $page->slug));

    $response->assertStatus(200)
        ->assertSee('This is a test excerpt');
});

test('page displays proper meta tags', function () {
    $page = Page::factory()->published()->create([
        'title' => 'SEO Test Page',
        'meta_title' => 'Custom Meta Title',
        'meta_description' => 'Custom meta description',
    ]);

    $response = $this->get(route('pages.show', $page->slug));

    $response->assertStatus(200)
        ->assertSeeInOrder(['<title>', 'Custom Meta Title'])
        ->assertSee('name="description" content="Custom meta description"', false);
});

test('page admin tools only show for admins', function () {
    $user = User::factory()->create();
    $admin = User::factory()->admin()->create();
    $draftPage = Page::factory()->draft()->create();

    // Regular user cannot see draft pages
    $response = $this->actingAs($user)->get(route('pages.show', $draftPage->slug));
    $response->assertStatus(404);

    // Admin can see draft pages and admin tools
    $response = $this->actingAs($admin)->get(route('pages.show', $draftPage->slug));
    $response->assertStatus(200)
        ->assertSee('This page is in draft mode and is only visible to administrators');
});
