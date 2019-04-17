<?php

namespace App\Http\Middleware;

use Closure;

class AllowIfActive
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
        if (auth()->user()->deactivated_at) {
            auth()->logout();

            abort(403);
        }

        return $next($request);
    }
}
