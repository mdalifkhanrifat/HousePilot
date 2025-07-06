<?php

namespace App\Services\Interfaces;

interface AuthServiceInterface
{
    /**
     * Authenticate user and return access token.
     *
     * @param array $credentials
     * @return mixed
     */
    public function login(array $credentials);

    /**
     * Register a new user and return access token.
     *
     * @param array $data
     * @return mixed
     */
    public function register(array $data);

    /**
     * Logout the authenticated user.
     *
     * @param mixed $user
     * @return mixed
     */
    public function logout($user);

    /**
     * Send password reset link and OTP to user.
     *
     * @param array $user
     * @return mixed
     */
    public function sendPasswordResetLink(array $user);

    /**
     * Reset password using token or OTP.
     *
     * @param array $data
     * @return mixed
     */
    public function resetPassword(array $data);

    /**
     * Send OTP to user's email for password reset.
     *
     * @param array $data
     * @return mixed
     */
    public function sendOtp(array $data);

    /**
     * Verify submitted OTP.
     *
     * @param array $data
     * @return mixed
     */
    public function verifyOtp(array $data);

    /**
     * Verify OTP and reset password.
     *
     * @param array $data
     * @return mixed
     */
    public function verifyOtpAndResetPassword(array $data);
}
