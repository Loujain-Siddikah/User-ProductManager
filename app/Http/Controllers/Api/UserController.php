<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
    use ApiResponses;
    public function user_info(){
        $user= Auth::user();
        return response()->json($user);
    }

    public function update(Request $request){

        $request->validate([
            'first_name' => 'string|max:255',
            'last_name' => 'string|max:255',
            'email' => 'email|unique:users',
            'phone' => 'unique:users|regex:/^[0-9]{10}$/',
           
        ]);
        $user= User::where('id',Auth::user()->id)->first();
        $user->first_name= $request->first_name;
        $user->last_name= $request->last_name;
        $user->email= $request->email;
        $user->phone= $request->phone;
        $user->save();
        return $this->success($user,'user information updated');
    } 
}



// forget password -> email (link) -> new password , verify ->Run(changePassword without oldPassword)
// in run check if generated date and time smaller than 2 hours then run else ask to regenrate token
// *link = xxcxvxcvxc.com/changepassword&token=token
// *token = usertoken
// *token must have generated date and time 