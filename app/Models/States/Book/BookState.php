<?php

namespace App\Models\States\Book;

use Spatie\ModelStates\State;
use Spatie\ModelStates\StateConfig;

abstract class BookState extends State
{
    public static function config(): StateConfig
    {
        return parent::config()
            ->default(Available::class)
            ->allowAllTransitions();
    }
}
