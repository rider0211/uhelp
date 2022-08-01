<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use GeoIP;
use App\Models\IPLIST;

class IPblockunblockMiddleware
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

        $restrictedCountry = GeoIP::getLocation($request->getClientIp());
      
        
        $iplist = IPLIST::where('ip', $request->getClientIp())->first();
        if($iplist == null){
            
            return $next($request);
        }else{
            if($iplist->types == 'Locked'){
                if(request()->session()->exists('redcaptcha')){
                  
                    return $next($request);
                }else{
                    if(setting('IPBLOCKTYPE') == 'captcha'){
                        $iplock = IPLIST::where('types', 'Locked')->pluck('ip')->toArray();
                        if (in_array($restrictedCountry->ip, $iplock)) {
        
                            return redirect()->route('ipblock');
                        }
                        return $next($request);
                    }
                    if(setting('IPBLOCKTYPE') == 'block'){
                        $iplock = IPLIST::where('types', 'Locked')->pluck('ip')->toArray();
                        if (in_array($restrictedCountry->ip, $iplock)) {
        
                            abort(403);
                        }
                        return $next($request);
                    }
                    
                }
                
            }
            elseif($iplist->types == 'Blocked'){
                $iplock = IPLIST::where('types', 'Blocked')->pluck('ip')->toArray();
                if (in_array($restrictedCountry->ip, $iplock)) {
                    abort(403);
                }
                return $next($request);
            }
            elseif($iplist->types == 'Unlock'){
                return $next($request);
            }
        }
        
    }
}
