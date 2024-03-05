<?php

namespace App\Repositories;

use App\Enums\RolesEnum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository implements UserRepositoryInterface 
{

    /**
     * get all users that verified their email.
     *
     * @return Collection
     */
    public function getAllUsers():Collection
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', RolesEnum::USER->value);
        })->whereNotNull('email_verified_at')->get();
        return $users;
    }

    /**
     * get a specific user.
     * 
     * @param User $user
     * @return User
     */
    public function getUser(User $user):User
    {
        return  $user;
    }

     /**
     * Admin create a new user.
     *
     * @param array $data
     * @return User
     */
    public function adminCreateUser(array $data): User
    {
        $user = User::create($data);
        $user->assignRole($data['role']);
        $user->email_verified_at = now();
        return $user;
    }

    /**
     * Update a user the given data.
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateUser(array $data):User
    {
        $user= User::where('id',Auth::user()->id)->firstOrFail();
        $user->update($data);
        return $user;
    }

     /**
     * Delete a user by ID.
     *
     * @param int $id
     * @return void
     */
    public function deleteUser(User $user):void
    {
        $user->tokens()->delete(); // Revoke all user tokens
        $user->delete();
    }
}