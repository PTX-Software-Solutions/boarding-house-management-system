<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsUserNotBanned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('web')->user()->isBanned()) {
            Auth::guard('web')->logout();
            $request->session()->regenerateToken();
            return redirect()->route('user.login')
                ->with('user-banned', "Your account has been banned!");
        }

        return $next($request);
    }
}
