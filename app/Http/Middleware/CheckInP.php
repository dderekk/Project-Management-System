<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInP
{
    //check for Inp type of users
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() && auth()->user()->type === 'Industry Partner') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Only Industry Partners can perform this action.');
    }
}
