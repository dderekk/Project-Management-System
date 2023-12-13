<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckStudentOrTeacher
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() && (auth()->user()->type === 'Student' || auth()->user()->type === 'Teacher')) {
            return $next($request);
        }

        return redirect('/')->with('error', 'Only Students or Teachers can perform this action.');
    }
}