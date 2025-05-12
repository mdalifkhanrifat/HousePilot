<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function findByEmail(string $email);
    public function create(array $data);
    public function sendPasswordResetLink(array $data);
}
