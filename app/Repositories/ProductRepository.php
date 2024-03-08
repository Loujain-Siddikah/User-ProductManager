<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\Product;
use App\Helpers\ImageHelper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Interfaces\ProductRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

 class ProductRepository implements ProductRepositoryInterface
{
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    /**
     * Get all products.
     *
     * @return LengthAwarePaginator
     */
    public function getAllProducts():LengthAwarePaginator
    {
        $products= $this->model->paginate(5);
        $products->load('user');
        return $products;
    }

    /**
     * Get auth user products.
     *
     * @return LengthAwarePaginator
     */
    public function getUserproducts():LengthAwarePaginator
    {
        $user = Auth::user();
        $products = $this->model->where('user_id',$user->id)->paginate(5);
        $products->load('user');
        return $products;
    }

    /**
     * Get other users products.
     *
     * @return LengthAwarePaginator
     */
    public function otherUserProducts(User $user): LengthAwarePaginator
    {
        $products = $user->products()->paginate(5);
        $products->load('user');
        return $products;
    }

    protected function saveImage($imageField, string $fileName): bool|string
    {
        if (!$imageField) {
            return null;
        }

        return ImageHelper::saveImage($imageField, $fileName);
    }

     /**
     * Create a new product.
     *
     * @param array $data
     * @param User $user
     * @return Product
     */
    public function CreateProduct(array $data, User $user): Product
    {       
        $data['image'] = $this->saveImage($data['image'], 'products_images');
        $data['user_id'] = $user->id;
        $product =  $this->model->create($data);
        // Eager load the user relationship
        $product->load('user');
        return $product;
    }

    /**
     * Update a product with the given data.
     *
     * 
     * 
     * @return Product
     */
    public function updateProduct(array $data, int $id): Product
    {
        $product = Product::findOrFail($id);
        $OldProductImage= $product->image;
        if(File::exists($OldProductImage)){
            File::delete($OldProductImage);
        }
        if(isset($data['image']))
        {
            $data['image'] = $this->saveImage($data['image'], 'products_images');
        }
        $product->update($data);
        $product->load('user');

        return $product;
    }

     /**
     * Delete a product.
     *
     * @param Product $product
     * @return void
     */
    public function destroyProduct(Product $product):void
    {
        $product->delete();
    }
}