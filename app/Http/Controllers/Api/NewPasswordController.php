<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use App\Traits\JsonResponseTrait;
class NewPasswordController extends Controller
{
    use JsonResponseTrait;

    public function sendResetLinkEmail(Request $request){
        try{
            $request->validate(['email' => 'required|email']);
            //we use built in password broker via password facade to send password reset link to user 
            // status slug وهي الميثود تعيد 
            $status = Password::sendResetLink($request->only('email'));
            // التحقق ما اذا تم ارسال رابط اعادة تعيين الباسوورد بنجاح ام لا
            //RESET_LINK_SENT وهو ثابت معرف في لارافيل يمثل استجابة ناجحة عند ارسال رابط للبريد الالكتروني بنجاح اي يشير الى ان التطبيق قد انشأ وارسل بريد الكتروني لليوزر
            //reset link statusويرسل بريد لليوزر و بعد ارسال البريد يستجيب التطبيق بال  uniqe reset token  عندما يطلب اليوزر اعادة تعيين الباسوورد يقوم التطبيق بانشاء    
            return $status === Password::RESET_LINK_SENT
                                        ? $this->jsonSuccessResponse('Reset link sent to your email',[],201)
                                        : $this->jsonErrorResponse('Unable to send reset link', 400);
                    //password_reset_tokens وحيتم وضع التوكين يلي عم ينبعت عالايميل بالداتابيز في جدول 
        }catch (\Exception $e) {
            throw new \Exception ('login failed');
        } 
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        try{
            //استخدمنا نفس الفاساد السابق لكن بتابع اخر يقوم هذا التابع بعمل فاليديت للايميل والباسوورد والتوكين ما اذا كانو صالحين واذا كانو صالحين سيتم استدعاء تابع يقوم بتحديث باسوورد اليوزر بباسورد جديدة
            $response = Password::reset(
                $request->only('email', 'password','token'),
                //كيف تعرف لارافيل انو سجل يوزر لازم تجيبو لتحدث الباسوورد تبعو 
                //الباسوورد بروكر بيستخدم نظام المصادقة ليرجع السجل الصح
                // config folder->auth.php->passwords->users   
                function ($user, $password) use ($request) {
                 // Compare the email from the request with the email of the user
                // associated with the provided reset token
                    if ($user->email !== $request->email) {
                        return Password::INVALID_USER;
                    }
                    $user->forceFill(['password' => Hash::make($password)])->save();
                        //يتم مسح كل التوكينز تبع اليوزر بكل الجداول
                    $user->tokens->each(function ($token) {
                            $token->delete();
                    });
                });
            if ($response === Password::PASSWORD_RESET) {
                return $this->jsonSuccessResponse('Password reset successfully, please login with your new password');
            } elseif ($response === Password::INVALID_USER) {
                return $this->jsonErrorResponse('Invalid user', 400);
            } else {
                return $this->jsonErrorResponse('Invalid reset token', 400);
            }
        }catch (\Exception $e) {
            throw new \Exception ('Reset Password failed');
        }         
    }  
}

