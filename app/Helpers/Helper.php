<?php

if (! function_exists('book_categories')) {
    function book_categories(): array
    {
        return [
            'fiction' => 'Fiction',
            'non_fiction' => 'Non-Fiction',
            'mystery' => 'Mystery',
            'sci_fi' => 'Science Fiction',
            'fantasy' => 'Fantasy',
            'romance' => 'Romance',
            'thriller' => 'Thriller',
            'biography' => 'Biography',
            'history' => 'History',
            'self_help' => 'Self-Help',
            'children' => "Children's",
            'young_adult' => 'Young Adult',
            'poetry' => 'Poetry',
        ];
    }
}
