<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AuthMiddleware
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
        if(setting('REGISTER_POPUP') == 'yes'){
            if (auth()->guest()) {
                return redirect('/');
            }
            return $next($request);
        }else{
            if (auth()->guest()) {
                
                return redirect()->route('auth.login');
            }
            return $next($request);
        }

        
    }
}
