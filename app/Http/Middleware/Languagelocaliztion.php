<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;

class Languagelocaliztion
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
        $mysql_link = @mysqli_connect(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'), env('DB_DATABASE'), env('DB_PORT'));
        if (mysqli_connect_errno() || !DB::getSchemaBuilder()->hasTable('settings') ) {
            return $next($request);
        }

        \App::setlocale(session()->get('locale') ?? @(DB::table('settings')->where('key', 'default_lang')->first()->value) );
        return $next($request);
    }
}
