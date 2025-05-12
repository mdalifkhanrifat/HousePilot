<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\ClientRepository;
use PHPUnit\Framework\Attributes\Test;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a Personal Access Client while the test is running.
        $clientRepository = new ClientRepository();
        $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            config('app.url')
        );
    }

    #[Test]
    public function user_can_register_successfully()
    {
        // Arrange: Prepare the data for registration
        $userData = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ];

        // Act: Send POST request to register
        $response = $this->postJson('/api/register', $userData);

        // Assert: Check if the user is successfully registered and saved in the database
        $response->assertStatus(201);
        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);
    }
}
