<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserHasName
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only check for authenticated users
        if (Auth::check() && empty(Auth::user()->name)) {
            // Allow access to the set-name routes to prevent redirect loop
            if (!$request->routeIs('set-name.form') && !$request->routeIs('set-name.store')) {
                return redirect()->route('set-name.form');
            }
        }

        return $next($request);
    }
}
