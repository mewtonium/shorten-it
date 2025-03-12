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

Route::controller(UrlController::class)
    ->as('url.')
    ->group(function () {
        Route::get('/{url:hash}', 'visit')->name('visit')->whereAlphaNumeric('hash');
    });

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
