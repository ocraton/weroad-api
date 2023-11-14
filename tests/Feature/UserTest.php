<?php

namespace Tests\Feature;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_create_user_command()
    {
        Role::create(['name' => 'editor']);
        Role::create(['name' => 'admin']);

        $this->artisan('user:create')
            ->expectsQuestion('Please provide a Name', 'John Doe')
            ->expectsQuestion('Please provide an Email', 'john@example.com')
            ->expectsQuestion('Please provide a password', 'secret')
            ->expectsQuestion('Set the role for the user:', 'admin')
            ->expectsOutput('User John Doe created successfully!')
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }
}
