<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\Product;
use App\Traits\ImageTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Contract\ProductRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;

class ProductRepository implements ProductRepositoryInterface
{
    use ImageTrait;
    protected $model;

    public function __construct(Product $product)
    {
        $this->model = $product;
    }

    public function getAllProducts()
    {
        $products= $this->model->paginate(5);
        $products->load('user');
        return $products;
    }

    public function getUserproducts()
    {
        $user = Auth::user();
        $products = $this->model->where('user_id',$user->id)->paginate(5);
        $products->load('user');
        return $products;
    }

    public function otherUserProducts(User $user)
    {
        $products = $user->products()->paginate(5);
        $products->load('user');
        return $products;
    }
 
    public function storeProduct(array $data)
    {       
        //saveImage method return the name of image
        $productImage_name=$this->saveImage($data['image'],'images/products/');
        $productData=[
            'name' => $data['name'],
            'description' => $data['description'],
            'user_id' => Auth::user()->id,
            'price' => $data['price'],
            //we will store the path of image in database
            'image'=>'/images/products'.$productImage_name,
        ];
        $product = $this->model->create($productData);
        // Eager load the user relationship
        $product->load('user');
        return $product;
    }

    public function updateProduct(array $data, Product $product)
    {
         // Check if the authenticated user owns the product
        if ($product->user_id !== Auth::user()->id) {
            throw new AuthorizationException('You are not authorized to update this product');
        }
        $OldProductImage= $product->image;
        if(File::exists($OldProductImage)){
            File::delete($OldProductImage);
        }
        $productImageName=$this->saveImage($data['image'],'images/products/');    
        $product->name = $data['name'];
        $product->description= $data['description'];
        $product->image= '/images/products'.$productImageName;
        $product->save();
        $product->load('user');
        return $product;
    }

    public function destroyProduct(Product $product)
    {
        if ($product->user_id !== Auth::user()->id){
            throw new AuthorizationException('You are not authorized to delete this product');
        }
        $product->delete();
        return $product;
    }
}