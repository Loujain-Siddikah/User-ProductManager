<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
// use VerificationCodeMail;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use App\Mail\VerificationCodeMail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use ApiResponses;
    public function register(StoreUserRequest $request) {
        $request->validate($request->rules(),$request->all());
        try {
            $verificationCode = random_int(1000, 9999);
            if ($request->has('email')) {
                $user = User::create([
                    'first_name'=> $request->first_name,
                    'last_name'=> $request->last_name,
                    'email'=>$request->email,
                    'password'=>Hash::make($request->password),
                    'verification_code'=> $verificationCode,
                ]);
            }elseif ($request->has('phone')) {
                $user = User::create([
                    'first_name'=> $request->first_name,
                    'last_name'=> $request->last_name,
                    'phone'=>$request->phone,
                    'password'=>Hash::make($request->password),
                    // 'verification_code'=> $verificationCode,
                ]);
            }else {
                return response()->json(['error' => 'Invalid registration data'], 400);
            }
            $token=$user->createToken('authToken'.$user->name)->plainTextToken;//token generated from user object and this method return Laravel\Sanctum\NewAccessToken instance  API tokens are hashed using SHA-256 hashing before being stored in database but you may access the plain-text value of the token using the plainTextToken property of the NewAccessToken instance.
            $userName=$user->first_name;
            Mail::to($user->email)->send(new VerificationCodeMail($verificationCode,$userName));
            $user->assignRole('user');
            //success method defined in ApiResponses trait 
            return $this->success($user,'Registytration successful. Check your email for the verification code.',$token);
        }catch (\Exception $e) {
             // Handle the error and return an error response
            return $this->error('Registration failed. Please try again later.',$e->getMessage(),500);

        }
    }

    public function verifyCode(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        if ($user->verification_code != $request->code) {
            return response()->json(['message' => 'Invalid verification code'], 422);
        }
        // Mark the user as verified
        $user->markEmailAsVerified();
        return response()->json(['message' => 'Email verification successful.'], 200);
    }

 
    public function login(LoginUserRequest $request){
        $request->validated($request->all());
        if(!Auth::attempt($request->only(['email', 'password']))){
            return $this->error('','credintial doesnt match',401);
        }
        $user= User::where('email',$request->email)->first();
        $token = $user->createToken('authToken'.$user->name)->plainTextToken;
        return $this->success($user,'login was succesful', $token);
    }

    public function logout(Request $request){
        // Get user who requested the logout
        $user = $request->user(); //or Auth::user()
        $user->tokens()->delete(); // Revoke all user tokens
        return response()->json('Logged out successfully');
    }
}
