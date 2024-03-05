<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\UserRepository;
use App\Http\Requests\AdminCreateNewUser;


class AdminController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function create_user(AdminCreateNewUser $request){
        // $this->authorize('create',$request->user);
        $user = $this->userRepository->adminCreateUser($request->validated());
        return $this->jsonSuccessResponse(
                'User created succesfully',
                UserResource::make($user)
            ); 
    }

    public function show_users(){
        $users= $this->userRepository->getAllUsers();
        return $this->jsonSuccessResponse(
            'All users who have completed the registration process have been get',
            UserResource::collection($users)
        );       
    }

    public function user_info(User $user)
    {
        $user_info = $this->userRepository->getUser($user);
        return $this->jsonSuccessResponse(
            'user info get succesfully',
            UserResource::make($user_info)
        );        
    }
 
    public function delete_user(User $user)
    {
        $this->authorize('delete',$user);
        $this->userRepository->deleteUser($user);
        return $this->jsonSuccessResponse('User deleted successfully');     
    }  
}
