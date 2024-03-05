<?php

use App\Http\Controllers\api\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\NewPasswordController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Spatie\Permission\Models\Role;

// use App\Http\Controllers\Api\UserController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Authentication Routes
Route::group(['controller' => AuthController::class],function(){
    Route::post('/register', 'register');
    Route::post('/login', 'authenticateUser');
    Route::post('/verify_code', 'verifyCode');
});

Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/logout', [AuthController::class, 'logout']);
});

// Admin Routes
Route::group(['middleware'=>'auth:sanctum', 'controller' => AdminController::class], function(){
    Route::post('/admin/create_user','create_user');
    Route::delete('/admin/delete_user/{user}','delete_user');
    Route::get('/admin/users','show_users');
    Route::get('/admin/users/{user}','user_info');
});

//User Routes
Route::group(['middleware'=>['auth:sanctum','verifyEmailWithCode'], 'controller' => UserController::class], function(){
    Route::get('/profile', 'user_profile');
    Route::post('/update_information', 'update');
    Route::get('/user_permissions', 'getUserPermissions');
});

Route::group(['middleware'=>['auth:sanctum','verifyEmailWithCode']], function(){
    Route::post('/forgot-password',[NewPasswordController::class,'sendResetLinkEmail'])->name('password.email');
    // for submit new passowrd form
    Route::post('/password/reset',[NewPasswordController::class,'resetPassword'])->name('password.reset');
    Route::apiResource('products',ProductController::class);
    Route::get('/profile/products',[ProductController::class,'user_products']);
    Route::get('/products/{user}/user_products/',[ProductController::class,'other_user_products']);
    
});




