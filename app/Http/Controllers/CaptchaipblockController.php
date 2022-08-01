<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Apptitle;
use App\Models\SocialAuthSetting;
use App\Models\Seosetting;
use GeoIP;
use App\Models\IPLIST;
use Cookie;

class CaptchaipblockController extends Controller
{
    public function index(){
        $ip = IPLIST::where('ip', request()->getClientIp())->first();
        if($ip != null){
            if($ip->types == 'Locked'){
                $title = Apptitle::first();
                $data['title'] = $title;
    
                $socialAuthSettings = SocialAuthSetting::first();
                $data['socialAuthSettings'] = $socialAuthSettings;
    
                $seopage = Seosetting::first();
                $data['seopage'] = $seopage;
                $cookie = Cookie::make('name', 'value', 120);
                return view('ipblock')->with($data);
            }else{
                return redirect('/');
            }
            
        }else{
            return redirect('/');
        }
    }


    public function update(Request $request){

        $this->validate($request, [
            'captcha' => ['required', 'captcha'],
            
        ]);
        
        $variable = $request->session()->put('redcaptcha', '123');
      
        return redirect('/');
        
    }

    public function captchasreload(){
        
        return response()->json(['captcha'=> captcha_img()]);
    }
}
