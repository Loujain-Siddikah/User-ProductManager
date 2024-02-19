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


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/verify_code', [AuthController::class, 'verifyCode']);


Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/logout', [AuthController::class, 'logout']);
});



Route::group(['middleware'=>['auth:sanctum','verifyEmailWithCode']], function(){
    Route::get('/profile',[UserController::class,'user_info']);
    Route::post('/update_information',[UserController::class,'update']);
    Route::post('/forgot-password',[NewPasswordController::class,'sendResetLinkEmail'])->name('password.email');
    // for submit new passowrd form
    Route::post('/password/reset',[NewPasswordController::class,'resetPassword'])->name('password.reset');
    Route::apiResource('products',ProductController::class);
    Route::get('/profile/products',[ProductController::class,'user_products']);
    Route::get('/products/{user}/user_products/',[ProductController::class,'other_user_products']);
    Route::post('/admin/create_user',[AdminController::class,'create_user']);
    Route::delete('/admin/delete_user/{id}',[AdminController::class,'delete_user']);
    Route::get('/admin/users/{user}',[AdminController::class,'user_info']);
    Route::get('/admin/users/{user}/products',[ProductController::class,'other_user_products']);
    Route::get('/admin/users',[AdminController::class,'show_users']);

});

// Route::fallback(function(){
//     return response()->json([
// });



