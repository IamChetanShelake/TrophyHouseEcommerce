<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ValidUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
         if (!Auth::check()) {
            return redirect()->route('login');
        }
         if (Auth::check() && Auth::user()->role == 0) {
        return $next($request); // Allow the request
    }
        // Otherwise, deny access or redirect
    else{
         return abort(403, 'Access denied. Admins are not allowed to access website.');
    }
    }
}
