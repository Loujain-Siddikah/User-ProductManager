<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\PermissionResource;

class UserController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
        
    }

    public function user_profile(){
        $user= Auth::user();
        $userInfo = $this->userRepository->getUser($user);
        return $this->jsonSuccessResponse(
            'user info get succesfully',
            UserResource::make($userInfo)
        ); 
    }

    public function update(UpdateUserRequest $request){
        $user = $this->userRepository->updateUser($request->validated());
        return $this->jsonSuccessResponse(
            'user information updated succesfully',
            UserResource::make($user)
        );

    }
    
}



