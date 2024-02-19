<?php

namespace App\Http\Controllers\Api;

use App\Traits\JsonResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateUserRequest;
use App\Contract\UserRepositoryInterface;

class UserController extends Controller
{
    use JsonResponseTrait;
    public function __construct(private UserRepositoryInterface $userRepository)
    {
        
    }

    public function user_info(){
        try{
            $user= Auth::user();
            $userInfo = $this->userRepository->getUser($user);
            return $this->jsonSuccessResponse('user info get succesfully',UserResource::make($userInfo)); 
        }catch (\Exception $e) {
            throw new \Exception ('get user information failed');
        } 
    }

    public function update(UpdateUserRequest $request){
        try{
            $user = $this->userRepository->updateUser($request->all());
            return $this->jsonSuccessResponse('user information updated succesfully',UserResource::make($user));
        }catch (\Exception $e) {
            throw new \Exception ('update user infoemation failed');
        } 
    } 
}



