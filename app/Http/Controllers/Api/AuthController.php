<?php

namespace App\Http\Controllers\Api;

use App\Traits\JsonResponseTrait;
use App\Mail\VerificationCodeMail;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use App\Contract\AuthRepositoryInterface;
use App\Contract\UserRepositoryInterface;
use App\Http\Requests\VerifyCodeRequest;

class AuthController extends Controller
{
    use JsonResponseTrait;
    public function __construct(private UserRepositoryInterface $repository, private AuthRepositoryInterface $authRepository)
    {
        
    }

    public function register(StoreUserRequest $request) {
        try{
            $userData = $this->authRepository->register($request->all());
            $user = $userData['user'];
            $verificationCode = $userData['verificationCode'];
            if ($request->has('email')) {
                $userName=$user->first_name;
                Mail::to($user->email)->send(new VerificationCodeMail($verificationCode,$userName));
            }
            return $this->jsonSuccessResponse('Registration Succesfully',UserResource::make($user)); 
        }catch (\Exception $e) {
            throw new \Exception ('Register failed');
        } 
       
  
    }

    public function verifyCode(VerifyCodeRequest $request)
    {
        try{
            $user = $this->authRepository->verifyCode($request->all());
            if ($user->verification_code != $request->code) {
                return $this->jsonErrorResponse('Invalid verification code', 422);
            }
            // This method sets the email_verified_at column in the users table to the current timestamp, marking the user's email as verified.
            $user->markEmailAsVerified();
            return $this->jsonSuccessResponse('Verification Succesfully',[UserResource::make($user)]);
        }catch (\Exception $e) {
            throw new \Exception ('verify code failed');
        } 
        
    }

    public function login(LoginUserRequest $request)
    {
        try{
            if(!Auth::attempt($request->only(['email', 'password']))){
                return $this->jsonErrorResponse('credintial doesnt match',401);
            }
            $userData=$this->authRepository->login($request->all());
            $user = $userData['user'];
            if($user->verification_code == true){
                return $this->jsonErrorResponse('verify your email',401);
            }
            $token = $userData['token'];
            return $this->jsonSuccessResponse('Login Succesfully',[UserResource::make($user), 'token'=>$token]);
        }catch (\Exception $e) {
            throw new \Exception ('login failed');
        } 
    }

    public function logout(){
        try{
            $user = auth()->user(); 
            $user->tokens()->delete(); // Revoke all user tokens
            return $this->jsonSuccessResponse('Logged out successfully');
        }catch (\Exception $e) {
            throw new \Exception ('login failed');
        }       
    }
}
