<?php

use App\Models\Post;
use App\Models\User;

test('home page displays latest posts using post card component', function () {
    $user = User::factory()->create();
    $posts = Post::factory()
        ->published()
        ->for($user)
        ->count(3)
        ->create();

    $response = $this->get('/');

    $response->assertSuccessful()
        ->assertSee('Latest Posts')
        ->assertSee($posts->first()->title)
        ->assertSee($posts->first()->user->name)
        ->assertSee('Read more →'); // This text is from the post-card component
});

test('home page shows empty state when no posts exist', function () {
    $response = $this->get('/');

    $response->assertSuccessful()
        ->assertSee('No Posts Yet')
        ->assertSee('working on creating amazing content');
});

test('home page shows newsletter subscription section', function () {
    $response = $this->get('/');

    $response->assertSuccessful()
        ->assertSeeLivewire('newsletter-subscription');
});
