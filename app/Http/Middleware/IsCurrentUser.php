<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsCurrentUser
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->route('user_id') == Auth::id() || Auth::user()->hasRole('Admin')) {
            return $next($request);
        } else {
            return Response('UnAutorized', 401);
        }
    }
}
