<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Contract\AuthRepositoryInterface;

class AuthRepository implements AuthRepositoryInterface 
{
    public function register(array $data)
    {
        $verificationCode = random_int(1000, 9999);
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'password' => Hash::make($data['password']),               
        ];

        if (isset($data['email'])) {
            $userData['email'] = $data['email'];
            $userData['verification_code'] = $verificationCode;
        } elseif (isset($data['phone'])) {
            $userData['phone'] = $data['phone'];
        }
        $user = User::create($userData);
        $user->assignRole('user');
        return ['user' => $user, 'verificationCode' => $verificationCode];
    }

    public function login(array $data)
    {
        $user= User::where('email',$data['email'])->first();
        $token = $user->createToken('authToken'.$user->name)->plainTextToken;
        return ['user' => $user, 'token' => $token];
    }

    public function verifyCode(array $data)
    {
        $user = User::where('email', $data['email'])->first();
        return $user;
    }

}