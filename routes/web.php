<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Route::get('/register',[AuthController::class, 'registerView'])->name('showRegisterationForm');
Route::post('/register_user',[AuthController::class,'register_user'])->name('register_user');
Route::get('/register_fake',[AuthController::class,'register_fake']);
Route::get('/afterregister', function () {
    return 'after register';});