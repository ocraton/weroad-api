<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $roleName): Response
    {

        if (auth()->check()) {

            if (auth()->user()->roles->contains('name', $roleName)) {
                return $next($request);
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthorized.'], 403);
        }

        abort(403, 'Unauthorized.');

    }
}
