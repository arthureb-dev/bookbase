<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\Role;
use App\Models\States\Book\Available;
use App\Models\States\Book\CheckedOut;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_returns_books()
    {
        // Create 5 random books.
        Book::factory()->count(5)->create();
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('books.index'));
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('books/Index')
            ->has('books', 5));
    }

    public function test_show_increments_page_count_once_per_session()
    {
        $book = Book::factory()->create(['page_count' => 0]);
        $user = User::factory()->create();
        $this->actingAs($user);
        Session::start();

        // First view should increment page_count.
        $this->get(route('books.show', $book->id));
        $book->refresh();
        $this->assertEquals(1, $book->page_count);

        // Second view in the same session should not increment.
        $this->get(route('books.show', $book->id));
        $book->refresh();
        $this->assertEquals(1, $book->page_count);
    }

    public function test_manage_requires_librarian_role()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get(route('books.manage'));
        $response->assertStatus(403);
    }

    public function test_manage_allows_librarian()
    {
        $librarian = User::factory()->create();
        $librarianRole = Role::factory()->create(['name' => 'librarian']);
        $librarian->roles()->attach($librarianRole);
        $this->actingAs($librarian);

        // Create some books that belong to the librarian.
        Book::factory()->count(3)->create(['user_id' => $librarian->id]);
        $response = $this->get(route('books.manage'));
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->component('books/Manage')
            ->has('books'));
    }

    public function test_checkout_available_book()
    {
        $user = User::factory()->create();
        // Book state is available if its state equals Available::class.
        $book = Book::factory()->create(['state' => Available::class]);
        $this->actingAs($user);

        $response = $this->patch(route('books.checkout', $book->id));
        $response->assertRedirect();
        $book->refresh();
        $this->assertInstanceOf(CheckedOut::class, $book->state);
        $this->assertNotNull($book->checked_out_at);
        $this->assertNotNull($book->due_date);
        $this->assertEquals($user->id, $book->checked_out_by);
    }

    public function test_checkout_unavailable_book_fails()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create(['state' => CheckedOut::class]);
        $this->actingAs($user);

        $response = $this->patch(route('books.checkout', $book->id));
        $response->assertSessionHasErrors();
    }

    public function test_review_allows_single_review_per_user()
    {
        $user = User::factory()->create();
        $book = Book::factory()->create();
        $this->actingAs($user);

        $data = [
            'rating' => 4,
            'comments' => 'Great book!',
        ];

        // First review submission should succeed.
        $response1 = $this->post(route('books.review', $book->id), $data);
        $response1->assertRedirect();
        $this->assertDatabaseHas('reviews', [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'rating' => 4,
            'comments' => 'Great book!',
        ]);

        // Second review submission should fail.
        $response2 = $this->post(route('books.review', $book->id), $data);
        $response2->assertSessionHasErrors();
    }

    public function test_search_returns_matching_books()
    {
        $book = Book::factory()->create(['title' => 'Unique Title For Search']);
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('books.search', ['q' => 'Unique Title']));
        $response->assertStatus(200);
        $response->assertInertia(fn ($page) => $page
            ->has('books.data')
            ->where('search', 'Unique Title'));
    }
}
