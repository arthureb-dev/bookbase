<?php

namespace App\Observers;

use App\Models\Book;
use Illuminate\Support\Str;

class BookObserver
{
    /**
     * Handle the Book "saving" event.
     */
    public function saving(Book $book): void
    {
        $book->slug = Str::of($book->title)->slug('-');
    }
}
