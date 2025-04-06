<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;

Route::inertia('/', 'Home')->name('home');

Route::middleware('auth.enabled')->group(function () {
    Route::inertia('/dashboard', 'Dashboard')->middleware(['auth', 'verified'])->name('home');

    require __DIR__.'/settings.php';
    require __DIR__.'/auth.php';
});

// URL route group must be the last defined due to `url.visit` matching anything after "/"
Route::controller(UrlController::class)
    ->as('url.')
    ->middleware('throttle:30,60')
    ->group(function () {
        Route::post('/url/shorten', 'shorten')->name('shorten');
        Route::get('/{hash}', 'visit')->name('visit')->whereAlphaNumeric('hash');
    });
