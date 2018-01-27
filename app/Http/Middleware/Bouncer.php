<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class Bouncer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if(Auth::user() && Auth::user()->role($role)) {
            return $next($request);
        }
        else {
            abort(403, 'You do not have access to this page!');
        }
    }
}
