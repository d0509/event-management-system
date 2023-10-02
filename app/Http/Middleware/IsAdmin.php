<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {       
        // dd(Auth::user()->role->name == config('site.role_names.admin'));
        
        if (Auth::user()->role->name == config('site.role_names.admin')) {
            return $next($request);
        } else {
            return redirect()->route('homepage');
        }
    }
}
