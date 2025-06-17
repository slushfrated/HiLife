<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStreak
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            $today = now()->toDateString();
            $yesterday = now()->subDay()->toDateString();
            if ($user->last_streak_date !== $today && $user->last_streak_date !== $yesterday) {
                if ($user->current_streak !== 0) {
                    $user->current_streak = 0;
                    $user->save();
                }
            }
        }
        return $next($request);
    }
}
