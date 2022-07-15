<?php

namespace App\Http\Middleware;

use Closure;

class CustomUrlMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currentURL = url()->current();
        cookie()->queue(cookie()->forever('custom_url', $currentURL));
        return $next($request);
    }
}
