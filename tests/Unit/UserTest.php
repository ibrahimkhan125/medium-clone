<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase; // ← this trait resets the DB for each test

    /** @test */
    public function a_user_can_be_created()
    {
        // arrange + act
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
        ]);

        // assert
        $this->assertDatabaseHas('users', [
            'email' => 'john@example.com',
        ]);

        $this->assertEquals('John Doe', $user->name);
    }
}
