<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;
use App\Enums\RolesEnum;
use App\Enums\PermissionsEnum;
use Illuminate\Support\Facades\Log;

class ProductPolicy
{

    /**
     * Determine whether the user can create models.
     * 
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {

    }

    /**
     * Determine whether the user can update the model.
     * 
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     * 
     * @param User $user
     * @param Product $product
     * @return bool
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id
                || 
                $user->hasRole(RolesEnum::ADMIN->value);
    }
}
