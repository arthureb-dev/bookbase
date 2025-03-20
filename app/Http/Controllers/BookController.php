<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Models\States\Book\Available;
use App\Models\States\Book\CheckedOut;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::inRandomOrder()->get();

        return Inertia::render('books/Index', [
            'books' => BookResource::collection($books),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        // Use a unique session key per book
        $sessionKey = 'book_viewed_'.$book->id;

        // If not viewed in this session, increment the page count
        if (! session()->has($sessionKey)) {
            $book->increment('page_count');
            session()->put($sessionKey, true);
        }

        return Inertia::render('books/Show', [
            'book' => new BookResource($book),
        ]);
    }

    /**
     * Display the list of books for management.
     */
    public function manage(Request $request)
    {
        if (! Gate::allows('manageAny', Book::class)) {
            abort(403);
        }

        $books = $request->user()->books()->latest('updated_at')->get();

        return Inertia::render('books/Manage', [
            'books' => BookResource::collection($books),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('books/Form', [
            'bookCategories' => book_categories(),
            'bookStates' => Book::getStatesFor('state'),
        ]);
    }

    /**
     * Store a newly created book.
     */
    public function store(StoreBookRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        $request->user()->books()->create($data);

        return to_route('books.manage')->with('success', 'Book created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Book $book)
    {
        return Inertia::render('books/Form', [
            'book' => new BookResource($book),
            'bookCategories' => book_categories(),
            'bookStates' => Book::getStatesFor('state'),
        ]);
    }

    /**
     * Update the specified book.
     */
    public function update(UpdateBookRequest $request, Book $book): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        } else {
            unset($data['cover_image']);
        }

        $book->update($data);

        return to_route('books.manage')->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('books.manage')->with('success', 'Book deleted.');
    }

    /**
     * Checkout the specified book.
     */
    public function checkout(Request $request, Book $book): RedirectResponse
    {
        if ($book->state->equals(Available::class)) {
            $book->update([
                'state' => CheckedOut::class,
                'checked_out_at' => now(),
                'due_date' => now()->addDays(5),
                'checked_out_by' => $request->user()->id,
            ]);

            return redirect()->back()->with('success', 'Book checked out successfully. It is due on '.now()->addDays(5)->format('F j, Y').'.');
        } else {
            return redirect()->back()->withErrors(['Book is not available for checkout.']);
        }
    }

    public function review(Request $request, Book $book): RedirectResponse
    {
        $user = $request->user();

        if ($book->reviews()->where('user_id', $user->id)->exists()) {
            return redirect()->back()->withErrors(['You have already reviewed this book.']);
        }

        $data = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comments' => 'required|string',
        ]);

        $book->reviews()->create([
            'user_id' => $user->id,
            'rating' => $data['rating'],
            'comments' => $data['comments'],
        ]);

        return redirect()->route('books.show', $book->id)->with('success', 'Book review added successfully.');
    }

    public function search(Request $request)
    {
        $query = Book::query();
        if ($search = $request->input('q')) {
            if (config('database.default') === 'sqlite') {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%")
                        ->orWhere('author', 'LIKE', "%{$search}%")
                        ->orWhere('isbn', 'LIKE', "%{$search}%")
                        ->orWhere('publisher', 'LIKE', "%{$search}%");
                });
            } else {
                $query->whereFullText(['title', 'description', 'author', 'isbn', 'publisher'], $search);
            }
        }
        $books = $query->paginate(10)->withQueryString();

        return Inertia::render('books/Search', [
            'books' => BookResource::collection($books),
            'search' => $search,
        ]);
    }
}
