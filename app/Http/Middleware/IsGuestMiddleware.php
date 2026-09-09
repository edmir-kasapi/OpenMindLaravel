<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsGuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {

            switch (Auth::user()->role->role) {
                case 'Admin':
                    return redirect()->route('admin.dashboard');
                    break;
                case 'User':
                    return redirect()->route('user.home');
                    break;
                case 'Store Operator':
                    return redirect()->route('operator.dashboard');
                    break;
            }

        }

        return $next($request);
    }
}
