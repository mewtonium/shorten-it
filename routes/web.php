<?php

use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

// URL route group must be the last defined due to `url.visit` matching anything after "/"
Route::controller(UrlController::class)
    ->as('url.')
    ->group(function () {
        Route::get('/{hash}', 'visit')->name('visit')->whereAlphaNumeric('hash');
    });
