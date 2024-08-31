<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;


        // kiểm tra xem người dùng đã xác thực với guard hiện tại chưa, ví dụ bên phía người dùng:  if (Auth::guard('admin')->attempt($request->only('email', 'password'))) -> true

        foreach ($guards as $guard) {
       
            if (Auth::guard($guard)->check()) { // trả về true nếu người dùng đã đăng nhập, sau đó thực hiện return
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
