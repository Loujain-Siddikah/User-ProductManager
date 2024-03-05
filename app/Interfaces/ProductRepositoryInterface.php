<?php
namespace App\Interfaces;

use App\Models\User;
use App\Models\Product;

interface ProductRepositoryInterface 
{
    /**
     * Get all products.
     *
     * @return mixed
     */
    public function getAllProducts():mixed;

    /**
     * Get user products.
     *
     * @return mixed
     */
    public function getUserproducts():mixed;

    /**
     * Get other users products.
     *
     * @return mixed
     */
    public function otherUserProducts(User $user):mixed;

    /**
     * Create a new product.
     *
     * @param array $data
     * @param User $user
     * @return mixed
     */
    public function CreateProduct(array $data, User $user):mixed;

    /**
     * Update an existing product.
     *
     * @return mixed
     */
    public function updateProduct(array $data, int $id):mixed;

     /**
     * Delete a product.
     *
     * @param int $id
     * @return void
     */
    public function destroyProduct(Product $product):void;
}