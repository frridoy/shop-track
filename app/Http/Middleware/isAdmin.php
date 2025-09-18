<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth = Auth::user();
        $isAdmin = $auth->user_type == 1;

        if (!$auth) {
            return redirect()->route('login');
        }

        if ($isAdmin) {
            return $next($request);
        }

        return redirect()->back();
    }
}
