<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helper\Installer\trait\ApichecktraitHelper;
use Auth;

class ApiCheckingMiddleware
{
    use ApichecktraitHelper;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(setting('envato_purchasecode') == null){
			if(Auth::check() && Auth::user()){

				return redirect()->route('admin.licenseinfo');
			}else{
				return $next($request);
			}
	    }else{
	        // Check purchase code
	        $purchaseCodeData = $this->purchaseCodeChecker(setting('envato_purchasecode'));
	        if ($purchaseCodeData->valid == false) {
	            return redirect('/apifailed');
	        }
	        if ($purchaseCodeData->valid == true) {
				if($purchaseCodeData->item_id != config('installer.requirements.itemId')){
                
					return redirect('/apifailed');
				}
				if($purchaseCodeData->item_id == config('installer.requirements.itemId')){
					$checkapis = $this->purchaseCodecheckingapi(setting('envato_purchasecode'));
					// Format object data
					$result = json_decode($checkapis);
					if($result != null){
						$url1 = parse_url($result->url);
						$url2 = parse_url(url('/'));
						if($url1['host'] == $url2['host']){
							if($result->status == 1){
								return $next($request);
							}else{
								return redirect('/apifailed');
							}
						}
						if($result->url != url('/')){
							return redirect('/apifailed');
						}
					}
					if($result == null){
						if(Auth::check() && Auth::user()){

							return redirect()->route('admin.licenseinfo');
						}else{
							return $next($request);
						}
					}

	        	}
	        }
	    }
    }
}
