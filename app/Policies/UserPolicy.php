<?php

namespace App\Policies;

use App\Enums\RolesEnum;
use App\Models\User;

class UserPolicy
{
    /**
     * Determine whether the user can create models.
     * @param User $user
     * @return bool
     */
    public function create(User $user): bool
    {
        return $user->hasRole(RolesEnum::ADMIN->value);
    }

    /**
     * Determine whether the user can update the model.
     * 
     */
    public function update(User $user)
    {
    
    }

    /**
     * Determine whether the user can delete the model.
     * user who make the action.
     * @param User $user
     * @return bool
     */
    public function delete(User $user): bool
    {
        return $user->hasRole(RolesEnum::ADMIN->value);
    }

}
