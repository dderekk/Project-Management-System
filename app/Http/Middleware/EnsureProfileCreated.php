<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Profile;

class EnsureProfileCreated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();  // 获取当前登录的用户

        if ($user && $user->type == 'Student' && !Profile::where('studentID', $user->id)->exists()){
            // Redirects to the page for creating a profile and displays an alert message
            return redirect('/profile')->with('error', 'Please create your profile.');
        }

        return $next($request);
    }
}
