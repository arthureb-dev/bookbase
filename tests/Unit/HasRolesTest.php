<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HasRolesTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_checks_role_by_name()
    {
        $role = Role::create(['name' => 'librarian']);
        $user = User::factory()->create();
        $user->roles()->attach($role->id);

        $this->assertTrue($user->hasRole('librarian'));
        $this->assertFalse($user->hasRole('customer'));
    }

    #[Test]
    public function it_checks_role_by_id()
    {
        $role = Role::create(['name' => 'customer']);
        $user = User::factory()->create();
        $user->roles()->attach($role->id);

        $this->assertTrue($user->hasRole($role->id));
        $this->assertFalse($user->hasRole(9999));
    }

    #[Test]
    public function it_checks_role_by_model_instance()
    {
        $role = Role::create(['name' => 'customer']);
        $user = User::factory()->create();
        $user->roles()->attach($role->id);

        $this->assertTrue($user->hasRole($role));
    }

    #[Test]
    public function it_checks_role_by_array()
    {
        $librarian = Role::create(['name' => 'librarian']);
        $customer  = Role::create(['name' => 'customer']);
        $user      = User::factory()->create();

        $user->roles()->attach($librarian->id);

        $this->assertTrue($user->hasRole(['customer', 'librarian']));
        $this->assertFalse($user->hasRole(['customer', 'writer']));
    }

    #[Test]
    public function it_checks_role_by_pipe_delimited_string()
    {
        $librarianRole = Role::create(['name' => 'librarian']);
        $user          = User::factory()->create();
        $user->roles()->attach($librarianRole->id);

        $this->assertTrue($user->hasRole('librarian|customer'));
        $this->assertFalse($user->hasRole('writer|customer'));
    }
}
