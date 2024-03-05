<?php

namespace App\Interfaces;

use App\Models\User;

interface AuthRepositoryInterface 
{
    public function register(array $data):mixed;
    public function createAccessToken(User $user): mixed;
    public function authenticateUser(array $data): mixed;
    public function verifyCode(array $data):mixed;
    public function logout():void;

}