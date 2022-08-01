<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

use Auth;
use Hash;
use App\Models\Apptitle;
use App\Traits\SocialAuthSettings;
use GuzzleHttp\Client;
use Laravel\Socialite\Facades\Socialite;
use App\Models\SocialAuthSetting;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Session;
use App\Models\Customer;
use App\Models\Seosetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Response;
use GeoIP;




class LoginController extends Controller

{
  use SocialAuthSettings, ThrottlesLogins, AuthenticatesUsers;

  public function showLoginForm()
    {

        $title = Apptitle::first();
        $data['title'] = $title;

        $socialAuthSettings = SocialAuthSetting::first();
        $data['socialAuthSettings'] = $socialAuthSettings;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;
        
        return view('user.auth.login')->with($data);
    }

    public function login(Request $request)
    {
        if(setting('CAPTCHATYPE') == 'off'){
            $request->validate([
                'email'     => 'required|exists:customers|max:255',
                'password'  => 'required|min:6|max:255',
                    
            ]);
        }else{
            if(setting('CAPTCHATYPE') == 'manual'){
                if(setting('RECAPTCH_ENABLE_LOGIN')=='yes'){
                    $this->validate($request, [
                        'email'     => 'required|exists:customers|max:255',
                        'password'  => 'required|min:6|max:255',
                        'captcha' => ['required', 'captcha'],
                        
                    ]);
                }else{
                    $this->validate($request, [
                        'email'     => 'required|exists:customers|max:255',
                        'password'  => 'required|min:6|max:255',
                    ]);  
                }

            }
            if(setting('CAPTCHATYPE') == 'google'){
                if(setting('RECAPTCH_ENABLE_LOGIN')=='yes'){
                    $this->validate($request, [
                        'email'     => 'required|exists:customers|max:255',
                        'password'  => 'required|min:6|max:255',
                        'g-recaptcha-response'  =>  'required|recaptcha',
                        
                    ]);
                }else{
                    $this->validate($request, [
                        'email'     => 'required|exists:customers|max:255',
                        'password'  => 'required|min:6|max:255',
                    ]);  
                }
            }
        }

        $credentials  = $request->only('email', 'password');
        $customerExist = Customer::where(['email' => $request->email, 'status' => 0])->exists();
        
        if ($customerExist) {
            return redirect()->back()->with('error',trans('langconvert.functions.customerinactive'));
        }
        
        $unverifiedCustomer = Customer::where('email', $request->email)->first();
        
        if (!empty($unverifiedCustomer) && $unverifiedCustomer->verified == 0) {
            return redirect()->back()->with('error',trans('langconvert.functions.unverifyuser'));
        }
        
        if (empty($unverifiedCustomer)) {
            return redirect()->back()->with('error',trans('langconvert.functions.nonregisteruser'));
        }
        
        if (Auth::guard('customer')->attempt($credentials)) {

            $cust = Customer::find(Auth::guard('customer')->id());
            $geolocation = GeoIP::getLocation(request()->getClientIp());
            $cust->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $geolocation->ip,
                'timezone' => $geolocation->timezone,
                'country' => $geolocation->country,
            ]);
            
            return redirect()->route('client.dashboard');
        }

        return back()->withInput()->withErrors(['email' => trans('langconvert.functions.invalidemailpass')]);

    }


    public function ajaxlogin(Request $request){
        if(setting('CAPTCHATYPE') == 'off'){
            $validator = Validator::make($request->all(), [
                'email'     => 'required|exists:customers|max:255',
                'password'  => 'required|min:6|max:255',
            ]);
            
        }else{
            if(setting('CAPTCHATYPE') == 'manual'){
                if(setting('RECAPTCH_ENABLE_LOGIN')=='yes'){
                    $validator = Validator::make($request->all(), [
                        'email'     => 'required|exists:customers|max:255',
                        'password'  => 'required|min:6|max:255',
                        'captcha' => ['required', 'captcha'],
                    ]);
                   
                }else{
                    $validator = Validator::make($request->all(), [
                        'email'     => 'required|exists:customers|max:255',
                        'password'  => 'required|min:6|max:255',
                    ]);
                     
                }

            }
            if(setting('CAPTCHATYPE') == 'google'){
                if(setting('RECAPTCH_ENABLE_LOGIN')=='yes'){
                    $validator = Validator::make($request->all(), [
                        'email'     => 'required|exists:customers|max:255',
                        'password'  => 'required|min:6|max:255',
                        'grecaptcharesponse'  =>  'recaptcha',
                    ]);
                    
                }else{
                    $validator = Validator::make($request->all(), [
                        'email'     => 'required|exists:customers|max:255',
                        'password'  => 'required|min:6|max:255',
                    ]);
                   
                }
            }
        }

        

        if ($validator->passes()) {
            $user = $request->email;
            $pass  = $request->password;
            $customerExist = Customer::where(['email' => $request->email, 'status' => 0])->exists();
        
        if ($customerExist) {
            return response()->json([ [5] ]);
        }
        $unverifiedCustomer = Customer::where('email', $request->email)->first();
        
        if (!empty($unverifiedCustomer) && $unverifiedCustomer->verified == 0) {
            return response()->json([ [4] ]);
        }
        if (Auth::guard('customer')->attempt(array('email' => $user, 'password' => $pass)))
        {
            $cust = Customer::find(Auth::guard('customer')->id());
            $cust->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $request->getClientIp()
            ]);
            return response()->json([ [1] ]);
            
        }
        else
         {  
            return response()->json([ [3] ]);
         }
        }
        else {
            return Response::json(['errors' => $validator->errors()]);
        }
    }

    public function ajaxslogin(Request $request)
    {
        $user = $request->email;
        $pass  = $request->password;
        $pass  = $request->grecaptcha;

        $customerExist = Customer::where(['email' => $request->email, 'status' => 0])->exists();
        
        if ($customerExist) {
            return response()->json([ [5] ]);
        }
        $unverifiedCustomer = Customer::where('email', $request->email)->first();
        
        if (!empty($unverifiedCustomer) && $unverifiedCustomer->verified == 0) {
            return response()->json([ [4] ]);
        }
        if (Auth::guard('customer')->attempt(array('email' => $user, 'password' => $pass)))
        {
            $cust = Customer::find(Auth::guard('customer')->id());
            $geolocation = GeoIP::getLocation(request()->getClientIp());
            $cust->update([
                'last_login_at' => Carbon::now()->toDateTimeString(),
                'last_login_ip' => $geolocation->ip,
                'timezone' => $geolocation->timezone,
                'country' => $geolocation->country,
            ]);
            return response()->json([ [1] ]);
            
        }
        else
         {  
            return response()->json([ [3] ]);
         }
    }


    public function logout()
    {
        
        request()->session()->flush();
        Auth::guard('customer')->logout();
        if(setting('REGISTER_POPUP') == 'yes'){
            
            return redirect()->route('home')->with('error',trans('langconvert.functions.logoutuser'));
        }else{
            return back()->with('error',trans('langconvert.functions.logoutuser'));
        }
    
        
    }

    // Social Login

    public function socialLogin($social)
    {
            $this->setSocailAuthConfigs();
            
            return Socialite::driver($social)->redirect();
    }
   /**
    * Obtain the user information from Social Logged in.
    * @param $social
    * @return Response
    */
    public function handleProviderCallback($social)
    {

        $this->setSocailAuthConfigs();
        $user = Socialite::driver($social)->user();
        $this->registerOrLogin($user);
        return redirect('customer/'); 
      }

      protected function registerOrLogin($data){

        $user = Customer::where('email', '=', $data->email)->first();
        if(!$user){

            $user = new Customer();
            $user->username = $data->name;
            $user->email = $data->email;
            $user->provider_id = $data->id;
            $user->status = '1';
            $user->verified = '1';
            $user->userType = 'Customer';
            $user->save();

        }
        Auth::guard('customer')->login($user);
        
    }
    
}
