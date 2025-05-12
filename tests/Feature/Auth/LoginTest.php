<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User; 
use Laravel\Passport\ClientRepository;
use PHPUnit\Framework\Attributes\Test;

class LoginTest extends TestCase
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
    public function user_can_login_successfully_with_valid_credentials()
    {
        // Arrange: Test data preparation
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password')
        ]);

        // Act: Perform login attempt
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        // Assert: Check for successful login response
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'user' => [
                         'id',
                         'name',
                         'email',
                         'email_verified_at',
                         'created_at',
                         'updated_at',
                     ],
                     'token',
                 ]);
    }

    #[Test]
    public function user_cannot_login_with_invalid_credentials()
    {
        // Arrange: Test data preparation
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        // Act: Attempt login with invalid credentials
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);

        // Assert: Check for failed login response
        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'Invalid credentials'
                 ]);
    }
}
