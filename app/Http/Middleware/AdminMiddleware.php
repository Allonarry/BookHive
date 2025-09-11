<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
   public function handle(Request $request, Closure $next)
{
    if (!Auth::check()) {
        return redirect()->route('login');
    }

    // Changed from is_admin to role check
    if (Auth::user()->role !== 'admin') {
        abort(403, 'Admin access required');
    }

    // Keep your existing blocked user logic if needed
    return $next($request);

     if (Auth::user()->is_blocked) {
        Auth::logout();
        return redirect()->route('login')
             ->withErrors(['account' => 'Your account has been blocked']);
    }
}


}
