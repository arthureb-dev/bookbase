<?php

namespace Tests\Feature\Auth;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'Pass!025@1',
            'password_confirmation' => 'Pass!025@1',
            'role' => Role::LIBRARIAN,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('books.index', absolute: false));
    }
}
