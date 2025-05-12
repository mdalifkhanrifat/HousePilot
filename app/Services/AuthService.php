<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthService implements AuthServiceInterface
{
    protected $userRepo;
    
    public function __construct(UserRepositoryInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function login(array $credentials)
    {
        if (!Auth::attempt($credentials)) {
            return false;
        }

        $user = $this->userRepo->findByEmail($credentials['email']);
        $token = $user->createToken('AccessToken')->accessToken;

        return ['user' => $user, 'token' => $token];
    }

    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepo->create($data);
        $token = $user->createToken('AccessToken')->accessToken;

        return ['user' => $user, 'token' => $token];
    }

    public function logout($user)
    {
        $user->token()->revoke();
        return true;
    }

    public function sendPasswordResetLink(array $data)
    {
        return $this->userRepo->sendPasswordResetLink($data);
    }
    
    public function resetPassword(array $data)
    {
        $status = Password::reset(
            $data,
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status;
    }

}
