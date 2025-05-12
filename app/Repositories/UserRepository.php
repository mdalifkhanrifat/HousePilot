<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Password;

class UserRepository implements UserRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function create(array $data)
    {
        return User::create($data);
    }

    public function sendPasswordResetLink(array $data)
    {
        return Password::sendResetLink($data);
    }
}
