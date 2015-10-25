<?php

namespace App\Http\Middleware;

use Closure;

use Illuminate\Http\RedirectResponse;

class AdminAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (\Auth::user()->role > 1) {
            //do nothing
        } else {
            return new RedirectResponse(url('/home'));
        }

        return $next($request);
    }
}
