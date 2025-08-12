<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSwaggerEnabled
{
    /**
     * Handle an incoming request.
     * If SWAGGER_ENABLED=false, return 404 to hide documentation in non-dev environments.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $enabled = filter_var(env('SWAGGER_ENABLED', false), FILTER_VALIDATE_BOOL);
        if (!$enabled) {
            abort(404);
        }
        return $next($request);
    }
}
