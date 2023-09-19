<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

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
        // dd(Auth::check());
        foreach ($guards as $guard) {
            if (Auth::guard()->check()) {
                if (Auth::user()->role->firstWhere('name', 'admin')) {
                    return redirect()->route('adminDashboard');
                    // dd(3);
                } else if (Auth::user()->role->firstWhere('name', 'company')) {
                    return redirect()->route('companyDashboard');
                } 
            }
        }

        return $next($request);
    }
}
