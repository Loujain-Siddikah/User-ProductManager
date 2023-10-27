<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Traits\ImageTrait;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    use ImageTrait;
    use ApiResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products= Product::paginate(20);
        return $this->success($products,'the products get succesfully');
    }
    
    public function user_products(){
        $user=Auth::user();
        $products=Product::where('user_id',$user->id)->paginate(20);
        return $this->success($products,'');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        try {
            $request->validated($request->all());
            //saveImage method return the name of image
            $productImage_name=$this->saveImage($request->image,'images/products/');
            // Create a new product associated with the authenticated user
            $product = Product::create([
                'name'=> $request->name,
                'description'=>$request->description,
                //we will store the path of image in database
                'image'=>'/images/products'.$productImage_name,
                'user_id'=> auth()->user()->id
            ]);
            return $this->success($product,'the product added succesfully', 201);
        }catch (ValidationException $e) {
            // Handle validation errors
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            return $this->error('','An error occurred while creating the product', 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        try{
            $request->validate($request->rules(),$request->all());
            $product=Product::findOrFail($id);
            $OldProductImage= $product->image;
            if(File::exists($OldProductImage)){
                File::delete($OldProductImage);
            }
            $productImage_name=$this->saveImage($request->image,'images/products/');    
            // }
            $product->name = $request->name;
            $product->description= $request->description;
            $product->image= '/images/products'.$productImage_name;
            $product->save();
            return $this->success('','Product updated successfully');
        }catch (\Exception $e) {
        // Handle any exceptions that may occur during the update
            return $this->error('','An error occurred while updating the product', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $product=Product::findOrFail($id);
            $product->delete();
            return $this->success('','Product deleted successfully');
        }catch (\Exception $e) {
            return $this->error('','An error occurred while deleting the product', 500);
        }
       
    }
}
