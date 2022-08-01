<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GeoIP;

class CountryblockunblockMiddleware
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
        $restrictedCountryListstring = setting('COUNTRY_LIST');
        $restrictedCountryList = explode(",", $restrictedCountryListstring);
        $restrictedCountry = GeoIP::getLocation($request->getClientIp());
        
        if (setting('COUNTRY_BLOCKTYPE') == 'block') {
            if(setting('COUNTRY_LIST') == null){
                return $next($request);
            }
            else{
                if (in_array($restrictedCountry->iso_code, $restrictedCountryList)) {
                    
                    abort(403);
                    
                }
                return $next($request);
            }
        }
        if(setting('COUNTRY_BLOCKTYPE') == 'allow'){
            if(setting('COUNTRY_LIST') == null){
                return $next($request);
            }else{
                if (in_array($restrictedCountry->iso_code, $restrictedCountryList)) {
                    return $next($request);
                }
                abort(403);
            }
        }
        
        
    }
}
