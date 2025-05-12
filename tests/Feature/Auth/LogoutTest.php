<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\TokenRepository;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // // Create a Personal Access Client while the test is running.
        $clientRepository = new ClientRepository();
        $clientRepository->createPersonalAccessClient(
            null,
            'Test Personal Access Client',
            config('app.url')
        );
    }

    #[Test]
    public function user_can_logout_successfully()
    {
        // Arrange: Prepare the user and log them in
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        // Act: Login and obtain an access token
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $token = $response->json('token');

        // Act: Make the logout request with the obtained token
        $response = $this->postJson('/api/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        // Assert: Check for successful logout response
        $response->assertStatus(200)
                 ->assertJson([
                     'message' => 'Logged out successfully', // Fixed the message
                 ]);
    }

    #[Test]
    public function user_cannot_logout_without_valid_token()
    {
        // Arrange: Create a user
        $user = User::factory()->create([
            'password' => bcrypt('password')
        ]);

        // Act: Try to log out without a token
        $response = $this->postJson('/api/logout');

        // Assert: Check for unauthorized response (status 401)
        $response->assertStatus(401)
                 ->assertJson([
                     'message' => 'Unauthenticated.', // Fixed the message (added period)
                 ]);
    }
}
