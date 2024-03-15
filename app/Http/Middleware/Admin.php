<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response; // Import the RedirectResponse class
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\RedirectResponse  // Correct the return type
     */
    public function handle(Request $request, Closure $next): Response // Correct the return type
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        if ($user->role == 1) {
            return $next($request);
        }

        if ($user->role == 2) {
            return redirect('/coordinator');
        }

        if ($user->role == 3) {
            return redirect('/student');
        }

        // Add a default redirect in case no conditions are met
        return redirect('/'); // You may want to customize this according to your application's logic
    }
}
