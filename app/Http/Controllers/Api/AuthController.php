<?php

namespace App\Http\Controllers\Api;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\AuthRepository;
use App\Interfaces\AuthRepositoryInterface;
use App\Http\Requests\Auth\LoginUserRequest;
use App\Http\Requests\Auth\VerifyCodeRequest;
use App\Http\Requests\User\CreateUserRequest;

class AuthController extends Controller
{
    public function __construct(private AuthRepositoryInterface $authRepository)
    {
        
    }

    public function register(CreateUserRequest $request) {
        $user = $this->authRepository->register($request->validated());
        if ($request->has('email')) {
            // Dispatch the UserRegistered event
            event(new UserRegistered($user));  
        }
        return $this->jsonSuccessResponse(
            'Registration Succesfully',
            UserResource::make($user)
        ); 
        
    }

    public function verifyCode(VerifyCodeRequest $request)
    {
        $user = $this->authRepository->verifyCode($request->validated());
        return $this->jsonSuccessResponse(
            'Verification Succesfully',
            UserResource::make($user)
        );       
    }

    public function authenticateUser(LoginUserRequest $request)
    {
        $user = $this->authRepository->authenticateUser($request->validated());
        // Create an access token for the authenticated user
        $token = $this->authRepository->createAccessToken($user);
        return $this->jsonSuccessResponse(
            'Login Succesfully',
            [UserResource::make($user), 'token'=>$token]
        );
    }

    public function logout(){
        $this->authRepository->logout();
        return $this->jsonSuccessResponse(
            'Logged out successfully'
        );
    }
}
