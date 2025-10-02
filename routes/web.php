<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', [App\Http\Controllers\PostController::class, 'home'])->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

// Posts routes
Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post:slug}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');

// Categories and Tags routes
Route::get('/categories/{category:slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');
Route::get('/tags/{tag:slug}', [App\Http\Controllers\TagController::class, 'show'])->name('tags.show');

// Contact route
Route::get('/contact', [App\Http\Controllers\ContactController::class, 'index'])->name('contact');

// Pages routes
Route::get('/pages/{page:slug}', function (\App\Models\Page $page) {
    // Only show published pages to non-admin users
    if (! $page->isPublished() && ! (auth()->check() && auth()->user()->is_admin)) {
        abort(404);
    }

    return view('pages.show', compact('page'));
})->name('pages.show');

require __DIR__.'/auth.php';
