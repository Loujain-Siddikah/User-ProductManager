<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class NewPasswordController extends Controller
{
    public function change_password(Request $request){
        $user= User::where('id',Auth::user()->id)->first();
        $request->validate([
            'old_password'=> 'required|min:6',
            'new_password'=>'required|min:6|confirmed'
        ]);
        if(Hash::check($request->old_password,$user->password)){
            $user->password= hash::make($request->new_password);
            $user->save();
            return response()->json('Password changed successfully');
            
        }else{
            return $this->error('','old password is incorrect'.$request->old_password.$user->password,422);
        }
    }

    //sendResetLinkEmail method to send the reset password email. Use Laravel's built-in PasswordBroker:

    public function sendResetLinkEmail(Request $request){
        $request->validate(['email' => 'required|email']);
//we use built in password broker via password facade to send password reset link to user 
// status slug وهي الميثود تعيد 
        $status = Password::sendResetLink(
            $request->only('email')
        );
    // التحقق ما اذا تم ارسال رابط اعادة تعيين الباسوورد بنجاح ام لا
    //RESET_LINK_SENT وهو ثابت معرف في لارافيل يمثل استجابة ناجحة عند ارسال رابط للبريد الالكتروني بنجاح اي يشير الى ان التطبيق قد انشأ وارسل بريد الكتروني لليوزر
    //reset link statusويرسل بريد لليوزر و بعد ارسال البريد يستجيب التطبيق بال  uniqe reset token  عندما يطلب اليوزر اعادة تعيين الباسوورد يقوم التطبيق بانشاء    
    return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email'], 201)
            : response()->json(['message' => 'Unable to send reset link'], 400);
            //  password_reset_tokens وحيتم وضع التوكين يلي عم ينبعت عالايميل بالداتابيز في جدول 
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'token' => 'required',
        ]);

        //استخدمنا نفس الفاساد السابق لكن بتابع اخر يقوم هذا التابع بعمل فاليديت للايميل والباسوورد والتوكين ما اذا كانو صالحين واذا كانو صالحين سيتم استدعاء تابع يقوم بتحديث باسوورد اليوزر بباسورد جديدة
        $response = Password::reset(
            $request->only('email', 'password', 'token'),
            //كيف تعرف لارافيل انو سجل يوزر لازم تجيبو لتحدث الباسوورد تبعو 
            //الباسوورد بروكر بيستخدم نظام المصادقة ليرجع السجل الصح
            // config folder->auth.php->passwords->users
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
                //يتم مسح كل التوكينز تبع اليوزر بكل الجداول
                $user->tokens->each(function ($token) {
                    $token->delete();
                });
            }
        );

        if ($response === Password::PASSWORD_RESET) {
            return response()->json(['message' => 'Password reset successfully']);
        } else {
            return response()->json(['message' => 'Invalid reset token'], 400);
        }
    }
}



// forget password -> email (link) -> new password , verify ->Run(changePassword without oldPassword)
// in run check if generated date and time smaller than 2 hours then run else ask to regenrate token
// *link = xxcxvxcvxc.com/changepassword&token=token
// *token = usertoken
// *token must have generated date and time 

