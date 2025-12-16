<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if user is authenticated and has admin role
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Redirect to home or login if not authenticated, or to unauthorized page if not admin
        if (!auth()->check()) {
            return redirect()->route('admin.login')->with('error', 'Please log in as an admin.');
        }

        // User is logged in but not an admin
        return redirect()->route('home')->with('error', 'You do not have permission to access the admin dashboard.');
    }
}
