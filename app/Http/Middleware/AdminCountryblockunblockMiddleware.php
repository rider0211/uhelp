<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GeoIP;

class AdminCountryblockunblockMiddleware
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
        $adminrestrictedCountryListstring = setting('ADMIN_COUNTRY_LIST');
        $adminrestrictedCountryList = explode(",", $adminrestrictedCountryListstring);
        $adminrestrictedCountry = GeoIP::getLocation($request->getClientIp());
        if (setting('ADMIN_COUNTRY_BLOCKTYPE') == 'block') {
            if(setting('ADMIN_COUNTRY_LIST') == null){
                return $next($request);
            }
            else{
                if (in_array($adminrestrictedCountry->iso_code, $adminrestrictedCountryList)) {
                
                    abort(403);
                    
                }
                return $next($request);
            }
        }
        if(setting('ADMIN_COUNTRY_BLOCKTYPE') == 'allow'){
            if(setting('ADMIN_COUNTRY_LIST') == null){
                return $next($request);
            }else{
                if (in_array($adminrestrictedCountry->iso_code, $adminrestrictedCountryList)) {
                    return $next($request);
                }
                abort(403);
            }
        }
    }
}
