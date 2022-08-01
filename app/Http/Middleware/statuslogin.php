<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class statuslogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $agent = Auth::check() && Auth::user()->status == 1;

        
            if(!$agent)
            {
                return redirect()->route('auth.login');
            }
            return $next($request);  
    }
}
