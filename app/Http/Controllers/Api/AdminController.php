<?php

namespace App\Http\Controllers\api;

use App\Contract\ProductRepositoryInterface;
use App\Models\User;
use App\Traits\JsonResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\AdminStoreNewUser;
use App\Contract\UserRepositoryInterface;


class AdminController extends Controller
{
    use JsonResponseTrait;
    public function __construct(private UserRepositoryInterface $repository, private ProductRepositoryInterface $productRepsitory)
    {
        $this->middleware('role:admin');
    }

    public function create_user(AdminStoreNewUser $request){
        try{
            $user = $this->repository->adminCreateUser($request->all());
            // make the email_verified column value is 1 and set the email_verified_at columm
            $user->markEmailAsVerified();
            return $this->jsonSuccessResponse('User created succesfully',UserResource::make($user)); 
        }catch (\Exception $e) {
            throw new \Exception ('An error occurred while creating the user');
        }  
    }

    public function show_users(){
        try{
            $users= $this->repository->getAllUsers();
            return $this->jsonSuccessResponse('All users who have completed the registration process have been get',[ UserResource::collection($users)]); 
        }catch (\Exception $e) {
            throw new \Exception ('An error occurred while retriving the user');
        }        
    }

    public function user_info(User $user){
        try{
            $user_info = $this->repository->getUser($user);
        return $this->jsonSuccessResponse('user info get succesfully',UserResource::make($user_info)); 
        }catch (\Exception $e) {
            throw new \Exception ('An error occurred while retriving user information');
        } 
    }
 
    public function delete_user($id){
        try{
            $user= User::findOrFail($id);
            $user->delete();
            return $this->jsonSuccessResponse('User deleted successfully');
        }catch (\Exception $e) {
            throw new \Exception ('An error occurred while deleting user');
        } 
       
    }  
}
