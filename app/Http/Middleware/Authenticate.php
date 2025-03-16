<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            abort(response()->json([
                'message' => 'Unauthorized',
            ], 401));
        }
    }

    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->auth->guard('sanctum')->guest()) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
        
        return $next($request);
    }
}

