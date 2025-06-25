<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Models\User;
use App\Models\PasswordOtp;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_reset_password_using_token()
    {
        $user = User::factory()->create(['email' => 'user@example.com']);
        $token = Password::createToken($user);

        $response = $this->postJson('/api/reset-password', [
            'email' => $user->email,
            'token' => $token,
            'password' => 'newpassword',
            'password_confirmation' => 'newpassword',
        ]);

        $response->assertStatus(200)->assertJson([
            'message' => 'Password reset via token successfully.'
        ]);

        $this->assertTrue(Hash::check('newpassword', $user->fresh()->password));
    }

    public function test_user_can_reset_password_using_otp()
    {
        $user = User::factory()->create(['email' => 'user@example.com']);
        PasswordOtp::create([
            'email' => $user->email,
            'otp' => '123456',
            'expires_at' => now()->addMinutes(10)
        ]);

        $response = $this->postJson('/api/reset-password-otp', [
            'email' => $user->email,
            'otp' => '123456',
            'password' => 'otpsecure',
            'password_confirmation' => 'otpsecure',
        ]);

        $response->assertStatus(200)->assertJson([
            'message' => 'Password reset via OTP successfully.'
        ]);

        $this->assertTrue(Hash::check('otpsecure', $user->fresh()->password));
    }
}
