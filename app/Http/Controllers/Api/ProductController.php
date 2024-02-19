<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Product;
use App\Traits\JsonResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;
use App\Contract\ProductRepositoryInterface;
use Illuminate\Auth\Access\AuthorizationException;

class ProductController extends Controller
{
    use JsonResponseTrait;

    public function __construct(private ProductRepositoryInterface $productRepository)
    {
        
    }
    public function index()
    {
        try{
        $products= $this->productRepository->getAllProducts();
         return $this->jsonSuccessResponse('the products get succesfully', new ProductCollection($products));
        }catch (\Exception $e) {
            throw new \Exception ('get products failed');
        }
    }
    
    public function user_products(){
        try{
        $products= $this->productRepository->getUserproducts();
        return $this->jsonSuccessResponse('my products get succesfully',  new ProductCollection($products));
        }catch (\Exception $e) {
            throw new \Exception ('get user products failed');
        }
    }

    public function other_user_products(User $user){
        try{
        $products= $this->productRepository->otherUserProducts($user);
        if ($products->isEmpty()) {
            return $this->jsonSuccessResponse('user doesnt have a products', [UserResource::make($user)]);
        }
        return $this->jsonSuccessResponse('user products get succesfully', new ProductCollection($products));
        }catch (\Exception $e) {
            // Handle other exceptions
            throw new \Exception ('get other user products failed');
        }
    }

    public function store(ProductRequest $request)
    {
        try {
           $product = $this->productRepository->storeProduct($request->validated());
            return $this->jsonSuccessResponse('the product added succesfully',ProductResource::make($product), 201);
        }catch (\Exception $e) {
            // Handle other exceptions
            throw new \Exception ('An error occurred while creating the product');
        }
    }


    public function update(ProductRequest $request, Product $product)
    {
        try{
            $product = $this->productRepository->updateProduct($request->all(), $product);
            return $this->jsonSuccessResponse('Product updated successfully',ProductResource::make($product));
        }catch(AuthorizationException $ex){
            throw new AuthorizationException($ex->getMessage());
        }catch (\Exception $e) {
            throw new \Exception ('An error occurred while updating the product');
        }
    }

    public function destroy(Product $product)
    {
        try{
            $product = $this->productRepository->destroyProduct($product);
            return $this->jsonSuccessResponse('Product deleted successfully', ProductResource::make($product));
        }catch(AuthorizationException $ex){
            throw new AuthorizationException($ex->getMessage());
        }catch (\Exception $e) {
            return $this->jsonErrorResponse('An error occurred while deleting the product', 500);
        }
       
    }
}
