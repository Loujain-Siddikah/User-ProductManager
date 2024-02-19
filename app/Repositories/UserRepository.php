<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Contract\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface 
{
    public function adminCreateUser(array $data)
    {
        $userData = [
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'password' => Hash::make($data['password']),               
        ];

        if (isset($data['email'])) {
            $userData['email'] = $data['email'];
        } elseif (isset($data['phone'])) {
            $userData['phone'] = $data['phone'];
        }
        $user = User::create($userData);
        $user->assignRole($data['role']);

        return $user;
    }

    public function getAllUsers() 
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->where('email_verified',1)->get();
        return $users;
    }

    public function getUser(User $user) 
    {
        return  $user;
    }

    public function deleteUser(User $user) 
    {
        $user->delete();
    }

    public function updateUser(array $data) 
    {
        $user= User::where('id',Auth::user()->id)->first();
        $user->update($data);
        return $user;
    }

}