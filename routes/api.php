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

// Route::middleware('auth:sanctum','verifyEmailWithCode')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
// ->middleware('VerifyEmailWithCode');
//protected routes
Route::group(['middleware'=>['auth:sanctum']],function(){
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/verify_code', [AuthController::class, 'verifyCode']);
});

Route::group(['middleware'=>['auth:sanctum','verifyEmailWithCode']], function(){
    Route::get('/user_informations',[UserController::class,'user_info']);
    Route::post('/update_userInfo',[UserController::class,'update']);
    Route::post('/change_password',[NewPasswordController::class,'change_password']);
    Route::post('/password/email',[NewPasswordController::class,'sendResetLinkEmail'])->name('password.email');
    Route::post('/password/reset',[NewPasswordController::class,'resetPassword'])->name('password.reset');
    Route::get('/user/products',[ProductController::class,'user_products']);
    Route::apiResource('products',ProductController::class);
    Route::post('/admin/create_user',[AdminController::class,'create_user']);
    Route::delete('/admin/delete_user/{id}',[AdminController::class,'delete_user']);
    Route::get('/admin/users/{user}',[AdminController::class,'user_info']);
    Route::get('/admin/users/{user}/products',[AdminController::class,'user_products']);
    Route::get('/admin/users',[AdminController::class,'show_users']);

});



