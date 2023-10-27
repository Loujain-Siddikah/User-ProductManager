<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class VerifyEmailWithCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
       
        $user = Auth::user();
        // Check if the user is verified using your verification code method
        if ($user && $user->email_verified_at!=null) {
            return $next($request);
        }

        return response()->json(['message' => 'Email verification required.'], 403);
        
    }
}
