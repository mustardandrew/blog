<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.index');
    })->name('dashboard');

    Route::view('/dashboard/bookmarks', 'dashboard.bookmarks')->name('dashboard.bookmarks');
});