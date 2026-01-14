<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureApiDocEnabled
{
    /**
     * Handle an incoming request.
     * If API_DOC=false, return 404 to hide documentation in non-dev environments.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $enabled = filter_var(env('API_DOC', false), FILTER_VALIDATE_BOOL);
        if (!$enabled) {
            abort(404);
        }
        return $next($request);
    }
}
