<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Role;


class AdminController extends Controller
{
    use ApiResponses;
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function create_user(Request $request){
        try {
            $request->validate([
                'first_name'=>'required|string|max:255',
                'last_name'=>'required|string|max:255',
                'email'=>'sometimes|email|required_without:phone|unique:users',
                'phone'=>'sometimes|unique:users|required_without:email|regex:/^[0-9]{10}$/',
                'password'=>'required|min:6',
                'role' => 'required|in:user,admin', // Validate the role
            ]);
            if ($request->has('email')) {
                $user = User::create([
                    'first_name'=> $request->first_name,
                    'last_name'=> $request->last_name,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password),
                ]);
            }elseif ($request->has('phone')) {
                $user = User::create([
                    'first_name'=> $request->first_name,
                    'last_name'=> $request->last_name,
                    'phone'=>$request->phone,
                    'password'=>Hash::make($request->password),
                ]);
            }else {
                return response()->json(['error' => 'Invalid data'], 400);
            }
            $user->markEmailAsVerified();
            $user->assignRole($request->role);
            return $this->success($user,'User created successfully');
        }catch (\Exception $e) {
            // Handle the error and return an error response
           return $this->error('User has not been created. Please try again later.',$e->getMessage(),500);
       }
    }

    public function show_users(){
        try{
            $users= User::where('email_verified',1)->get();
            return $this->success($users,'');
        }catch (\Exception $e) {
            return $this->error('', $e->getMessage(),500);
        }
    }

    public function user_products(User $user){
        try{
            $userWithProducts = User::with('products')->find($user->id);
            $products = $userWithProducts->products;
            return $this->success($products,''); 
        }catch (\Exception $e) {
            return $this->error('', $e->getMessage(),500);
        }
    }

    public function user_info(User $user){
        try{
            $user_info = User::find($user->id);
            return $this->success($user_info,''); 
        }catch (\Exception $e) {
            return $this->error('', $e->getMessage(),500);
        }
    }
    public function delete_user($id){
        try{
            $user= User::findOrFail($id);
            $user->delete();
            return $this->success('','User deleted successfully');
        }catch (\Exception $e) {
            return $this->error('deleting failed. Please try again later.', $e->getMessage(),500);
        }

    }
}
