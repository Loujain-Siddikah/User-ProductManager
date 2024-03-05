<?php

namespace App\Interfaces;

use App\Models\User;

interface UserRepositoryInterface 
{
    public function getAllUsers():mixed;
    public function getUser(User $user):mixed;
    public function adminCreateUser(array $attributes):mixed;
    public function updateUser(array $data):mixed;
    public function deleteUser(User $user):void;

}