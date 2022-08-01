<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Checkinstallation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $installedpath = storage_path('installed');

        if(!file_exists($installedpath)){
            $request->session()->flush();
            return redirect()->route('SprukoAppInstaller::welcome');
        }

        return $next($request);
    }
}
