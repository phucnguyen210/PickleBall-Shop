<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AdminRedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {


        $admin = Auth::guard('admin')->user();
        if (Auth::guard('admin')->check()) {
            if ($admin && $admin->role == 1) {
                return redirect() -> route('admin.dashboard');
            }

        }
        // if (Auth::guard('admin')->check()) {
        //     return redirect()->route('admin.dashboard');
        // }


        return $next($request);
    }
}
