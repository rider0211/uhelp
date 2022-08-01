<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class CustomerAuthenicate
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
        if(Auth::guard('customer')->check() && Auth::guard('customer')->user()->status == '1'){
            return $next($request);
            }else{
                Auth::guard('customer')->logout();
                return redirect()->route('auth.login');
            }
    }
}
