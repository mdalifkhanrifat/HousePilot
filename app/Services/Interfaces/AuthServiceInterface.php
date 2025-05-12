<?php

namespace App\Services\Interfaces;

interface AuthServiceInterface
{
    public function login(array $credentials);
    public function register(array $data);
    public function logout($user);
    public function sendPasswordResetLink(array $user);
    public function resetPassword(array $data);

}