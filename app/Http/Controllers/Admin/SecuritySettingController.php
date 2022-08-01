<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Seosetting;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Setting;
use App\Models\Countries;
use GeoIP;

class SecuritySettingController extends Controller
{
    public function index(){
        
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $country = Countries::all();
        $data['countries'] = $country;

        return view('admin.securitysetting.securitysetting')->with($data);
    }

    public function store(){



        $data['COUNTRY_BLOCKTYPE'] = request()->countryblock;
        if(request()->countrylist){
            $countrycode = implode(',',request()->countrylist);
            $data['COUNTRY_LIST'] = $countrycode;
        }else{
            $data['COUNTRY_LIST'] = request()->countrylist;
        }
        
        $this->updateSettings($data);
        return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
    }

    public function adminstore(){

        $admincountry =GeoIP::getLocation(request()->getClientIp());
   
        if(request()->admincountryblock == 'block'){
            if(request()->admincountrylist){
                if(in_array($admincountry->iso_code,request()->admincountrylist)){
                    return redirect()->back()->with('error', trans('langconvert.functions.countrylistblock'));
                }else{
                    $data['ADMIN_COUNTRY_BLOCKTYPE'] = request()->admincountryblock;
                    if(request()->admincountrylist){
                        $admincountrycode = implode(',',request()->admincountrylist);
                        $data['ADMIN_COUNTRY_LIST'] = $admincountrycode;
                    }else{
                        $data['ADMIN_COUNTRY_LIST'] = request()->admincountrylist;
                    }

                    $this->updateSettings($data);
                    return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
                }
            }else{
                $data['ADMIN_COUNTRY_BLOCKTYPE'] = request()->admincountryblock;
                if(request()->admincountrylist){
                    $admincountrycode = implode(',',request()->admincountrylist);
                    $data['ADMIN_COUNTRY_LIST'] = $admincountrycode;
                }else{
                    $data['ADMIN_COUNTRY_LIST'] = request()->admincountrylist;
                }
                $this->updateSettings($data);
                return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
            }
        
        }
        if(request()->admincountryblock == 'allow'){
            if(request()->admincountrylist){
                if(in_array($admincountry->iso_code,request()->admincountrylist)){
                    $data['ADMIN_COUNTRY_BLOCKTYPE'] = request()->admincountryblock;
                    if(request()->admincountrylist){
                        $admincountrycode = implode(',',request()->admincountrylist);
                        $data['ADMIN_COUNTRY_LIST'] = $admincountrycode;
                    }else{
                        $data['ADMIN_COUNTRY_LIST'] = request()->admincountrylist;
                    }
                    $this->updateSettings($data);
                    return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
                }else{
                    return redirect()->back()->with('error', trans('langconvert.functions.countrylistblock'));
                }
            }else {
                $data['ADMIN_COUNTRY_BLOCKTYPE'] = request()->admincountryblock;
                    if(request()->admincountrylist){
                        $admincountrycode = implode(',',request()->admincountrylist);
                        $data['ADMIN_COUNTRY_LIST'] = $admincountrycode;
                    }else{
                        $data['ADMIN_COUNTRY_LIST'] = request()->admincountrylist;
                    }
                    $this->updateSettings($data);
                    return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
            }
        }
            
        
    }

    public function dosstore(){

        $this->validate(request(), [
            'ip_max_attempt' => ['required', 'numeric', 'digits_between:1,10000'],
            'ip_seconds' => ['required', 'numeric', 'digits_between:1,10000'],
            
        ]);

        $data['IPBLOCKTYPE'] = request()->ipblocktype;
        $data['IPMAXATTEMPT'] = request()->ip_max_attempt;
        $data['IPSECONDS'] = request()->ip_seconds;
        $data['DOS_Enable'] =  request()->has('dosswitch') ? 'on' : 'off';
        
        $this->updateSettings($data);
        return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
    }


    public function emailtoticket(){

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $country = Countries::all();
        $data['countries'] = $country;

        return view('admin.securitysetting.emailtoticket')->with($data);
    }

    public function emailticketstore()
    {
        $this->validate(request(), [

            'imap_host' => ['required', 'max:255'],
            'imap_port' => ['required', 'numeric', 'between:1,10000'],
            'imap_encryption' => ['required', 'max:255'],
            'imap_protocol' => ['required', 'max:255'],
            'imap_username' => ['required', 'max:255'],
            'imap_password' => ['required', 'max:255'],
            
        ]);

        $data['IMAP_STATUS'] = request()->has('IMAP_STATUS') ? 'on' : 'off';
        $data['IMAP_HOST'] = request()->input('imap_host');
        $data['IMAP_PORT'] = request()->input('imap_port');
        $data['IMAP_ENCRYPTION'] = request()->input('imap_encryption');
        $data['IMAP_PROTOCOL'] = request()->input('imap_protocol');
        $data['IMAP_USERNAME'] = request()->input('imap_username');
        $data['IMAP_PASSWORD'] = request()->input('imap_password');
        $this->updateSettings($data);
        
        return redirect()->back()->with('success', trans('langconvert.functions.updatecommon'));
        
    }


    /**
     *  Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    private function updateSettings($data)
    {

        foreach($data as $key => $val){
        	$setting = Setting::where('key', $key);
        	if( $setting->exists() )
        		$setting->first()->update(['value' => $val]);
        }

    }

    public function setLanguage($locale)
    {
      
        \App::setlocale($locale);        
        session()->put('locale', $locale);
        return redirect()->back()->with('success', trans('langconvert.functions.languageupdate'));
    }
}
