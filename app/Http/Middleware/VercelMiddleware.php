<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VercelMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->secure() && env('APP_ENV') === 'production') {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
