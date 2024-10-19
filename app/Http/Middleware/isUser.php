<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->role === "user") {
            return $next($request);
        } else {
            Auth::logout();
            return redirect()->route('account.login')->with('error', 'Unauthorized access.');
        }
    }
}
