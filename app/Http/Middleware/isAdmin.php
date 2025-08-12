<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Check if user is authenticated and their role is 1
    if (Auth::check() && Auth::user()->role == 1) {
        return $next($request); // Allow the request
    }
    // else if (Auth::check() && Auth::user()->role == 0){
    //     // Otherwise, deny access or redirect
    //     return redirect()->route('Websitehome');
    // }
    else{
         return redirect()->route('Websitehome');
    }
    }
}
