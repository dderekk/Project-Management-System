<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStudent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    // check for student type of user
    public function handle($request, Closure $next)
{
    if (auth()->check() && auth()->user()->type == 'Student') {
        return $next($request);
    }

    return redirect('/')->with('error', 'Only students can apply for projects.');
}
}
