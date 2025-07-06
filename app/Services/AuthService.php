<?php

namespace App\Services;

use App\Services\Interfaces\AuthServiceInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Carbon\Carbon;

use App\Notifications\ResetPasswordNotification;
use App\Models\PasswordOtp;

class AuthService implements AuthServiceInterface
{
    protected $userRepo;

    /**
     * Constructor to inject UserRepositoryInterface.
     */
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * Handle user login.
     *
     * @param array $credentials
     * @return array|bool
     */
    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return false;
        }

        $user = $this->userRepo->findByEmail($credentials['email']);
        $token = $user->createToken('AccessToken')->accessToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    /**
     * Register a new user.
     *
     * @param array $data
     * @return array
     */
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepo->create($data);
        $token = $user->createToken('AccessToken')->accessToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    /**
     * Logout the authenticated user.
     *
     * @param mixed $user
     * @return bool
     */
    public function logout($user)
    {
        $user->token()->revoke();
        return true;
    }

    /**
     * Send OTP to user's email for password reset.
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
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
        $user->notify(new ResetPasswordNotification(null, $otp)); // Only OTP sent

        return response()->json(['message' => 'OTP sent successfully.'], 200);
    }

    /**
     * Verify the OTP submitted by the user.
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
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
     * Reset password after verifying OTP.
     *
     * @param array $data
     * @return array
     */
    public function verifyOtpAndResetPassword(array $data)
    {
        $otpRecord = PasswordOtp::where('email', $data['email'])
            ->where('otp', $data['otp'])
            ->first();

        if (!$otpRecord || Carbon::now()->greaterThan($otpRecord->expires_at)) {
            return [
                'success' => false,
                'message' => 'Invalid or expired OTP'
            ];
        }

        $user = $this->userRepo->findByEmail($data['email']);
        $user->password = Hash::make($data['password']);
        $user->save();

        $otpRecord->delete();

        return [
            'success' => true,
            'message' => 'Password has been reset successfully'
        ];
    }

    /**
     * Send password reset token + OTP to user email.
     *
     * @param array $user
     * @return array
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

        return [
            'success' => true,
            'message' => 'Reset link sent to your email.'
        ];
    }

    /**
     * Reset password using either OTP or token.
     *
     * @param array $data
     * @return array
     */
    public function resetPassword(array $data)
    {
        // OTP-based reset
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

        // Token-based reset
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
            }

            return ['success' => false, 'message' => __($status)];
        }

        return ['success' => false, 'message' => 'OTP or token is required.'];
    }
}
