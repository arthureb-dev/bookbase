<?php

use App\Console\Commands\RefreshBookList;
use Illuminate\Support\Facades\Schedule;

Schedule::command(RefreshBookList::class)->daily();
