<?php

use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/books/manage', [BookController::class, 'manage'])->name('books.manage');
    Route::resource('/books', BookController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
