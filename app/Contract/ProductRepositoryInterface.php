<?php
namespace App\Contract;

use App\Models\User;
use App\Models\Product;

interface ProductRepositoryInterface 
{
    public function getAllProducts();
    public function getUserproducts();
    public function otherUserProducts(User $user);
    public function storeProduct(array $data);
    public function updateProduct(array $data, Product $product);
    public function destroyProduct(Product $product);
}