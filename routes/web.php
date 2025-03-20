<?php

use App\Http\Controllers\BookController;
use App\Models\Book;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'books' => Book::inRandomOrder()->take(4)->get(),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/books/manage', [BookController::class, 'manage'])->name('books.manage');
    Route::get('/books/search', [BookController::class, 'search'])->name('books.search');
    Route::patch('/books/{book}/checkout', [BookController::class, 'checkout'])->name('books.checkout');
    Route::post('/books/{book}/review', [BookController::class, 'review'])->name('books.review');
    Route::resource('/books', BookController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
