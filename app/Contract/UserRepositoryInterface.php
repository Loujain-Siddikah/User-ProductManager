<?php

namespace App\Contract;

use App\Models\User;

interface UserRepositoryInterface 
{
    public function getAllUsers();
    public function getUser(User $user);
    public function deleteUser(User $user);
    public function adminCreateUser(array $attributes);
    public function updateUser(array $data);
}