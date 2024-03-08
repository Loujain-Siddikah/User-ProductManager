<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Product;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\ProductResource;
use App\Http\Requests\Product\CreateProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Interfaces\ProductRepositoryInterface;

class ProductController extends Controller
{

    public function __construct(private ProductRepositoryInterface $productRepository)
    {       
    }

    public function index()
    {
        $products= $this->productRepository->getAllProducts();
         return $this->jsonSuccessResponse(
            'the products get succesfully',
            new ProductResource($products)
        );

    }
    
    public function user_products(){
        $products= $this->productRepository->getUserproducts();
        return $this->jsonSuccessResponse(
            'my products get succesfully',
            new ProductResource($products)
        );
    }

    public function other_user_products(User $user){
        $products= $this->productRepository->otherUserProducts($user);
        if ($products->isEmpty()) {
            return $this->jsonSuccessResponse(
                'user doesnt have a products',
                 [UserResource::make($user)]
            );
        }
        return $this->jsonSuccessResponse(
            'user products get succesfully',
            new ProductResource($products)
        );
    }

    public function store(CreateProductRequest $request)
    {
        $product = $this->productRepository->CreateProduct($request->validated(), $request->user());
        return $this->jsonSuccessResponse(
            'the product added succesfully',
            ProductResource::make($product),
             201
        );
    }

   
    public function update(UpdateProductRequest $request, int $id)
    {
        $product = $this->productRepository->updateProduct($request->validated(), $id);
        return $this->jsonSuccessResponse(
            'Product updated successfully',
            ProductResource::make($product)
        );
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete',$product);
        $product = $this->productRepository->destroyProduct($product);
        return $this->jsonSuccessResponse(
            'Product deleted successfully',
        );      
    }
}
