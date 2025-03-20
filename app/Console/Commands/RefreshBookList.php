<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\States\Book\Available;
use Carbon\Carbon;
use Illuminate\Console\Command;

class RefreshBookList extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:refresh-book-list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh book list, handle returned books.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $books = Book::whereState('state', 'checked_out')->where('due_date', '<', $now)->get();

        foreach ($books as $book) {
            $book->update([
                'state' => Available::class,
                'checked_out_at' => null,
                'due_date' => null,
                'checked_out_by' => null,
            ]);
        }

        $this->info("Processed {$books->count()} overdue books.");

        return 0;
    }
}
