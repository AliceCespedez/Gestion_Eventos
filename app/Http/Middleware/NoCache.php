<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NoCache
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        return $response->header('Cache-Control', 'no-cache, no-store, must-revalidate, proxy-revalidate, max-age=0, private')
            ->header('Pragma', 'no-cache')
            ->header('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT')
            ->header('Vary', '*');
    }
}
