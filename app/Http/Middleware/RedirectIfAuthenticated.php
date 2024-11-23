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
        foreach ($guards as $guard) {
            if (Auth::guard()->check()) {
                if (Auth::user()->role_id == config('site.roles.admin')) {
                    return redirect()->route('admin.dashboard');
                } else if (Auth::user()->role_id == config('site.roles.company')) {
                    return redirect()->route('company.dashboard');
                }
            }
        }

        return $next($request);
    }
}
