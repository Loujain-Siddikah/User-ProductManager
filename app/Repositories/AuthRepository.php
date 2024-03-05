<?php

namespace App\Repositories;

use App\Models\User;
use App\Enums\RolesEnum;
use App\Interfaces\AuthRepositoryInterface;
use App\Exceptions\InvalidVerificationCodeException;


class AuthRepository implements AuthRepositoryInterface 
{
    /**
     * Create a new user.
     *
     * @param array $data
     * @return User
     */
    public function register(array $data):User
    {
        $verificationCode = random_int(1000, 9999);
        $data['verification_code'] = $verificationCode;
        $user = User::create($data);
        $user->assignRole(RolesEnum::USER->value);
        return $user;
    }

    /**
     * Verify a given code.
     *
     * @param array $data
     * @return User
     * @throws InvalidVerificationCodeException
     */

    public function verifyCode(array $data):User
    {
        $user = User::where('email', $data['email'])->firstOrFail();
        if ($user->verification_code !== $data['code']) {
            throw new InvalidVerificationCodeException;
        }
        $user->email_verified_at = now();
        $user->save();
        return $user;
    }

    /**
     * Create an access token for the given user.
     *
     * @param User $user
     * @return string
     */
    public function createAccessToken(User $user): string
    {
        return $user->createToken('Personal Access Token')->plainTextToken;
    }

    /**
     * Authenticate a user with the given data.
     *
     * @param array $data
     * @return User
     *
     */
    public function authenticateUser(array $data): User
    {
        $user= User::where('email',$data['email'])->firstOrFail();
        if($user->email_verified_at == null){
            throw new \Exception('you cant login you should verify your code.');
        }
        return $user;
    }

    /**
     * logout the user.
     *
     * @return void
     */
    public function logout():void
    {
        $user = auth()->user(); 
        $user->tokens()->delete(); // Revoke all user tokens
    }

}