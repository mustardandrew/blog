<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

require __DIR__.'/auth.php';

// Dashboard routes
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard home page
    Route::view('/dashboard', 'pages.dashboard.index')->name('dashboard');

    // Dashboard comments page
    Route::view('dashboard/comments', 'pages.dashboard.comments')->name('dashboard.comments');

    // Dashboard bookmarks page
    Route::view('/dashboard/bookmarks', 'pages.dashboard.bookmarks')->name('dashboard.bookmarks');
});

// Settings routes
Route::middleware(['auth'])->group(function () {
    // Profile settings page
    Route::redirect('settings', 'settings/profile');
    Route::view('settings/profile', 'pages.settings.profile')->name('profile.edit');

    // Avatar settings page
    Route::view('settings/avatar', 'pages.settings.avatar')->name('settings.avatar');

    // Password settings page
    Route::view('settings/password', 'pages.settings.password')->name('password.edit');

    // Two-Factor Authentication settings page
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
Route::get('/pages/{page:slug}', [App\Http\Controllers\PageController::class, 'show'])->name('pages.show');


