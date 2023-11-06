<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // admin routes are only for admin role
        // authenticated user ဖြစ်ရင် login , register page ကို သွားလို့မရဘူး
        if (!empty(Auth::user())) {
            if (url()->current() == route('auth#loginPage') || url()->current() == route('auth#registerPage')) {
                return back();
            }

            if (Auth::user()->role != "admin") {
                return back();
            }
            return $next($request); // authenticate ဖြစ်ပြိး အပေါ်က rule တွေနဲ့ မညိရင် next request ကိုသွားမယ်
        }
        // authenticate မဖြစ်ရင် သွားချင်တဲ့ next request ကို သွားခိုင်းမယ်
        return $next($request);
    }
}
