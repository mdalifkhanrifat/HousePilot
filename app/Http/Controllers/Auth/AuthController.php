<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthServiceInterface $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Handle user login.
     */
    public function login(LoginRequest $request)
    {
        $result = $this->authService->login($request->validated());

        if (!$result) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json($result);
    }

    /**
     * Handle new user registration.
     */
    public function register(RegisterRequest $request)
    {
        $result = $this->authService->register($request->validated());

        return response()->json($result, 201);
    }

    /**
     * Handle user logout (token revocation).
     */
    public function logout(Request $request)
    {
        $this->authService->logout($request->user());

        return response()->json(['message' => 'Logged out successfully']);
    }

    // -----------------------------------------------------------------------
    // Forgot Password via Token (Standard Laravel Reset)
    // -----------------------------------------------------------------------

    /**
     * Send reset link + OTP to email using Laravel's Password::createToken
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $status = $this->authService->sendPasswordResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email.'])
            : response()->json(['message' => 'Unable to send reset link.'], 500);
    }

    /**
     * Reset password using token (link method)
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = $this->authService->resetPassword($request->only(
            'email', 'password', 'password_confirmation', 'token'
        ));

        if ($status == Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successfully.']);
        }

        // dd($status);

        return response()->json(['message' => __($status['message'])], 500);
    }


    // -----------------------------------------------------------------------
    // OTP-Based Password Reset
    // -----------------------------------------------------------------------

    /**
     * Send OTP to user email for password reset
     */
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);
        return $this->authService->sendOtp($request->only('email'));
    }

    /**
     * Verify OTP sent to user email
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);
        return $this->authService->verifyOtp($request->only('email', 'otp'));
    }

    /**
     * Reset password using OTP (verified manually)
     */
    public function resetPasswordViaOtp(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'otp'      => 'required|digits:6',
            'password' => 'required|confirmed|min:8',
        ]);

        $result = $this->authService->verifyOtpAndResetPassword(
            $request->only('email', 'otp', 'password')
        );

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 400);
        }

        return response()->json(['message' => $result['message']]);
    }

    // -----------------------------------------------------------------------
    //  Hybrid Endpoint (either OTP or Token-based reset in one)
    // -----------------------------------------------------------------------

    /**
     * Alternative combined endpoint to reset password via OTP or Token.
     */
    public function resetPasswordWithOtp(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'otp'      => 'sometimes|required_without:token|digits:6',
            'token'    => 'sometimes|required_without:otp|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $result = $this->authService->resetPassword($request->only(
            'email', 'otp', 'token', 'password'
        ));

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 400);
        }

        return response()->json(['message' => $result['message']]);
    }

    /**
     * Alternative entry point to send both OTP and reset link.
     */
    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $result = $this->authService->sendPasswordResetLink($request->only('email'));

        if (!$result['success']) {
            return response()->json(['message' => $result['message']], 400);
        }

        return response()->json(['message' => $result['message']]);
    }
}
