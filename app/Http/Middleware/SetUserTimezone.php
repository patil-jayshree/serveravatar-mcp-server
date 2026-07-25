<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetUserTimezone
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check() && auth()->user()->timezone) {
            date_default_timezone_set(auth()->user()->timezone);
            config(['app.timezone' => auth()->user()->timezone]);
        }

        return $next($request);
    }
}
