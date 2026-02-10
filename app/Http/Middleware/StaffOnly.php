<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffOnly
{
    public function handle(Request $request, Closure $next)
    {
        // Allow only staff users
        if (Auth::check() && Auth::user()->role === 'staff') {
            return $next($request);
        }
        
        // Redirect unauthorized users
        return redirect()->route('dashboard')->with('error', 'Access denied. Staff access only.');
    }
}