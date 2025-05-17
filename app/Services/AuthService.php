<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

use App\Notifications\ResetPasswordNotification;
use App\Models\PasswordOtp;

class AuthService implements AuthServiceInterface
{
    protected $userRepo;

    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Handle user login.
     */
    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return false;
        }

        $user = $this->userRepo->findByEmail($credentials['email']);
        $token = $user->createToken('AccessToken')->accessToken;

        return ['user' => $user, 'token' => $token];
    }

    /**
     * Register a new user.
     */
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepo->create($data);
        $token = $user->createToken('AccessToken')->accessToken;

        return ['user' => $user, 'token' => $token];
    }

    /**
     * Logout the authenticated user.
     */
    public function logout($user)
    {
        $user->token()->revoke();
        return true;
    }

    /**
     * Send OTP to user's email for password reset.
     */
    public function sendOtp(array $data)
    {
        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(config('auth.otp_expiry', 10));

        PasswordOtp::updateOrCreate(
            ['email' => $data['email']],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        $user = $this->userRepo->findByEmail($data['email']);
        $user->notify(new ResetPasswordNotification(null, $otp)); // null token, only OTP

        return response()->json(['message' => 'OTP sent successfully.'], 200);
    }

    /**
     * Verify the OTP submitted by the user.
     */
    public function verifyOtp(array $data)
    {
        $otpRecord = PasswordOtp::where('email', $data['email'])
            ->where('otp', $data['otp'])
            ->first();

        if (!$otpRecord || Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return response()->json(['message' => 'OTP is invalid or expired.'], 400);
        }

        return response()->json(['message' => 'OTP verified.'], 200);
    }

    /**
     * Reset password via OTP verification.
     */
    public function verifyOtpAndResetPassword(array $data)
    {
        $otpRecord = PasswordOtp::where('email', $data['email'])
            ->where('otp', $data['otp'])
            ->first();

        if (!$otpRecord || Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return ['success' => false, 'message' => 'Invalid or expired OTP'];
        }

        $user = $this->userRepo->findByEmail($data['email']);
        $user->password = Hash::make($data['password']);
        $user->save();

        $otpRecord->delete();

        return ['success' => true, 'message' => 'Password has been reset successfully'];
    }

    /**
     * Send both password reset token and OTP via notification.
     * Token is used for Laravel's built-in password reset, and OTP is for manual validation.
     */
    public function sendPasswordResetLink(array $user)
    {
        $userRecord = $this->userRepo->findByEmail($user['email']);
        if (!$userRecord) {
            return ['success' => false, 'message' => 'User not found.'];
        }

        $token = Password::createToken($userRecord);

        $otp = rand(100000, 999999);
        PasswordOtp::updateOrCreate(
            ['email' => $user['email']],
            ['otp' => $otp, 'expires_at' => now()->addMinutes(10)]
        );

        $userRecord->notify(new ResetPasswordNotification($token, $otp));

        return ['success' => true, 'message' => 'Reset password instructions sent.'];
    }

    /**
     * Reset password either via OTP or via token.
     * Best Practice:
     * - Token handled using Laravel's Password Broker.
     * - OTP handled manually from password_otps table.
     */
    public function resetPassword(array $data)
    {
        if (isset($data['otp'])) {
            $otpRecord = PasswordOtp::where('email', $data['email'])
                ->where('otp', $data['otp'])
                ->where('expires_at', '>=', now())
                ->first();

            if (!$otpRecord) {
                return ['success' => false, 'message' => 'Invalid or expired OTP.'];
            }

            $user = $this->userRepo->findByEmail($data['email']);
            if (!$user) {
                return ['success' => false, 'message' => 'User not found.'];
            }

            $user->password = Hash::make($data['password']);
            $user->save();
            $otpRecord->delete();

            return ['success' => true, 'message' => 'Password reset via OTP successfully.'];
        }

        if (isset($data['token'])) {
            $status = Password::reset(
                $data,
                function ($user, $password) {
                    $user->forceFill([
                        'password' => Hash::make($password),
                    ])->save();
                }
            );

            if ($status === Password::PASSWORD_RESET) {
                return ['success' => true, 'message' => 'Password reset via token successfully.'];
            } else {
                return ['success' => false, 'message' => __($status)];
            }
        }

        return ['success' => false, 'message' => 'OTP or token is required.'];
    }


}
