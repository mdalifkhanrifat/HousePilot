<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ResetPasswordNotification;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_request_password_reset_link_and_otp()
    {
        Notification::fake();
        $user = User::factory()->create();

        $response = $this->postJson('/api/forgot-password', ['email' => $user->email]);

        $response->assertStatus(200)->assertJson([
            'message' => 'Reset link sent to your email.'
        ]);

        Notification::assertSentTo($user, ResetPasswordNotification::class);
    }
}
