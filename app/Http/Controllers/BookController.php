<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
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
        return Inertia::render('books/Index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        //
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
}
