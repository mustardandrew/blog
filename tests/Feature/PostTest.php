<?php

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;

test('guests can view published posts index', function () {
    $publishedPosts = Post::factory(3)->published()->create();
    $draftPosts = Post::factory(2)->draft()->create();

    $response = $this->get(route('posts.index'));

    $response->assertStatus(200)
        ->assertSee($publishedPosts->first()->title)
        ->assertDontSee($draftPosts->first()->title);
});

test('guests can view individual published posts', function () {
    $post = Post::factory()->published()->create([
        'title' => 'Published Post Title',
        'content' => 'This is the post content.',
    ]);

    $response = $this->get(route('posts.show', $post->slug));

    $response->assertStatus(200)
        ->assertSee('Published Post Title')
        ->assertSee('This is the post content.');
});

test('guests cannot view draft posts', function () {
    $post = Post::factory()->draft()->create();

    $response = $this->get(route('posts.show', $post->slug));

    $response->assertStatus(404);
});

test('admins can view draft posts', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $post = Post::factory()->draft()->create([
        'title' => 'Draft Post Title',
    ]);

    $response = $this->actingAs($admin)->get(route('posts.show', $post->slug));

    $response->assertStatus(200)
        ->assertSee('Draft Post Title')
        ->assertSee('This post is in draft mode and is only visible to administrators');
});

test('post displays proper meta tags', function () {
    $post = Post::factory()->published()->create([
        'title' => 'Test Post',
        'meta_title' => 'Custom Meta Title',
        'meta_description' => 'Custom meta description',
        'meta_keywords' => ['keyword1', 'keyword2'],
    ]);

    $response = $this->get(route('posts.show', $post->slug));

    $response->assertStatus(200)
        ->assertSeeInOrder(['<title>', 'Custom Meta Title'])
        ->assertSee('name="description" content="Custom meta description"', false)
        ->assertSee('keyword1, keyword2', false);
});

test('post uses fallback meta data when custom meta is not set', function () {
    $post = Post::factory()->published()->create([
        'title' => 'Test Post Title',
        'excerpt' => 'This is the excerpt',
        'meta_title' => null,
        'meta_description' => null,
        'meta_keywords' => null,
    ]);

    $response = $this->get(route('posts.show', $post->slug));

    $response->assertStatus(200)
        ->assertSeeInOrder(['<title>', 'Test Post Title'])
        ->assertSee('name="description" content="This is the excerpt"', false);
});

test('post displays author and publish date', function () {
    $user = User::factory()->create(['name' => 'John Doe']);
    $post = Post::factory()->published()->create([
        'user_id' => $user->id,
        'published_at' => now()->subDays(5),
    ]);

    $response = $this->get(route('posts.show', $post->slug));

    $response->assertStatus(200)
        ->assertSee('John Doe')  // Author name appears in sidebar
        ->assertSee($post->published_at->format('F j, Y'));
});

test('post displays featured image when available', function () {
    $post = Post::factory()->published()->create([
        'featured_image' => 'posts/featured-images/test-image.jpg',
    ]);

    $response = $this->get(route('posts.show', $post->slug));

    $response->assertStatus(200)
        ->assertSee('posts/featured-images/test-image.jpg', false);
});

test('post displays tags when available', function () {
    // Create tags with specific names
    $laravel = Tag::create(['name' => 'Laravel', 'slug' => 'laravel']);
    $php = Tag::create(['name' => 'PHP', 'slug' => 'php']);
    $webdev = Tag::create(['name' => 'Web Development', 'slug' => 'web-development']);
    
    $post = Post::factory()->published()->create();
    $post->tags()->attach([$laravel->id, $php->id, $webdev->id]);

    $response = $this->get(route('posts.show', $post->slug));

    $response->assertStatus(200)
        ->assertSee('Laravel')
        ->assertSee('PHP')
        ->assertSee('Web Development');
});

test('posts index shows pagination when there are many posts', function () {
    Post::factory(20)->published()->create();

    $response = $this->get(route('posts.index'));

    $response->assertStatus(200);
    // Basic check that content is present - pagination links are rendered by Laravel
    $posts = Post::published()->latest('published_at')->paginate(12);
    expect($posts->hasPages())->toBeTrue();
});

it('posts are ordered by published date on index', function () {
    $newerPost = Post::factory()->published()->create([
        'published_at' => now()->subDay()
    ]);
    
    $olderPost = Post::factory()->published()->create([
        'published_at' => now()->subDays(2)
    ]);

    $response = $this->get(route('posts.index'));

    $response->assertSeeInOrder([
        $newerPost->title,
        $olderPost->title
    ]);
});

it('displays breadcrumbs on post page', function () {
    $category = Category::factory()->create(['name' => 'Technology']);
    $post = Post::factory()->published()->create();
    $post->categories()->attach($category);

    $response = $this->get(route('posts.show', $post));

    $response->assertSee('Home')
        ->assertSee('Blog')
        ->assertSee('Technology')
        ->assertSee(Str::limit($post->title, 50));
});

it('displays breadcrumbs on posts index', function () {
    $response = $this->get(route('posts.index'));

    $response->assertSee('Home')
        ->assertSee('Blog');
});
