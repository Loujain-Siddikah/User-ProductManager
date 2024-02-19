<?php

namespace App\Contract;

use App\Models\User;

interface AuthRepositoryInterface 
{
    public function register(array $attributes);
    public function login(array $data);
    public function verifyCode(array $data);

}