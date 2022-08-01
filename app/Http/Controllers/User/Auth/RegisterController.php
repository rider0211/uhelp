<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Models\Profile\UserProfile;
use App\Models\Apptitle;
use App\Models\VerifyUser;
use App\Mail\VerifyMail;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Response;
use Illuminate\Support\Facades\Input;
use App\Notifications\NewUserNotification;
use App\Models\Seosetting;
use App\Models\CustomerSetting;
use GeoIP;
use App\Traits\SocialAuthSettings;
use App\Models\SocialAuthSetting;

use Mail;
use App\Mail\mailmailablesend;

class RegisterController extends Controller
{
    use RegistersUsers, SocialAuthSettings;
   
    public function showRegistrationForm(){

        $title = Apptitle::first();
        $data['title'] = $title;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $socialAuthSettings = SocialAuthSetting::first();
        $data['socialAuthSettings'] = $socialAuthSettings;
        

        return view('user.auth.register')->with($data);
    }

    public function register(Request $request){

          
        $guest = Customer::where('email', '=', $request->email)->first();

        if(Customer::where('email', '=', $request->email)->exists() ){

            if($guest->password == null && $guest->provider_id == null && $guest->userType == 'Guest'){

                if(setting('CAPTCHATYPE') == 'off'){
                    $validator = Validator::make($request->all(), [
                        'firstname' => 'required|max:255',
                        'lastname' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:customers',
                        'password' => 'required|min:8|confirmed',
                    ]);
                }else{
                    if(setting('CAPTCHATYPE') == 'manual'){
                        if(setting('RECAPTCH_ENABLE_REGISTER')=='yes'){
                            $validator = Validator::make($request->all(), [
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|email|max:255|unique:customers',
                                'password' => 'required|min:8|confirmed',
                                'captcha' => ['required', 'captcha'],
                            ]);
                        }else{
                            $validator = Validator::make($request->all(), [
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|email|max:255|unique:customers',
                                'password' => 'required|min:8|confirmed',
                            ]); 
                        }
        
                    }
                    if(setting('CAPTCHATYPE') == 'google'){
                        if(setting('RECAPTCH_ENABLE_REGISTER')=='yes'){
                            $validator = Validator::make($request->all(), [
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|email|max:255|unique:customers',
                                'password' => 'required|min:8|confirmed',
                                'g-recaptcha-response'  =>  'required|recaptcha',
                            ]);
                        }else{
                            $validator = Validator::make($request->all(), [
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|email|max:255|unique:customers',
                                'password' => 'required|min:8|confirmed',
                            ]);  
                        }
                    }
                }
                
                $geolocation = GeoIP::getLocation(request()->getClientIp());

                $guest->firstname = $request->firstname;
                $guest->lastname = $request->lastname;
                $guest->username = $request->firstname .' '. $request->lastname;
                $guest->password = Hash::make($request->password);
                $guest->userType = 'Customer';
                $guest->country = $geolocation->country;
                $guest->timezone = $geolocation->timezone;
                $guest->update();

                $verifyUser = VerifyUser::create([
                    'cust_id' => $guest->id,
                    'token' => sha1(time())
                ]);
                $verifyData = [
        
                    'username' => $guest->username,
                    'email' => $guest->email,
                    'email_verify_url' => route('verify.email',$verifyUser->token),
        
                ];
        
                try{
        
                    Mail::to($guest->email)
                    ->send( new mailmailablesend( 'customer_sendmail_verification', $verifyData ) );
        
                
                }catch(\Exception $e){
                   
                    
                    return redirect()->route('auth.login')->with('success', trans('langconvert.functions.newuserregister'));        
                }
    
                return redirect()->route('auth.login')->with('success', trans('langconvert.functions.newuserregister'));        
    
    
            }
    
            else{


                if(setting('CAPTCHATYPE') == 'off'){
                    $request->validate([
                        'firstname' => 'required|max:255',
                        'lastname' => 'required|max:255',
                        'email' => 'required|string|email|max:255|unique:customers',
                        'password' => 'required|string|min:8|confirmed',
                        'password_confirmation' => 'required',
                        'agree_terms' =>  'required|in:agreed',
                    ]);
                }else{
                    if(setting('CAPTCHATYPE') == 'manual'){
                        if(setting('RECAPTCH_ENABLE_REGISTER')=='yes'){
                            $request->validate([
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|string|email|max:255|unique:customers',
                                'password' => 'required|string|min:8|confirmed',
                                'password_confirmation' => 'required',
                                'agree_terms' =>  'required|in:agreed',
                                'captcha' => ['required', 'captcha'],
                            ]);
                            
                        }else{
                            $request->validate([
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|string|email|max:255|unique:customers',
                                'password' => 'required|string|min:8|confirmed',
                                'password_confirmation' => 'required',
                                'agree_terms' =>  'required|in:agreed',
                                
                            ]);
                           
                        }
        
                    }
                    if(setting('CAPTCHATYPE') == 'google'){
                        if(setting('RECAPTCH_ENABLE_REGISTER')=='yes'){
                            $request->validate([
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|string|email|max:255|unique:customers',
                                'password' => 'required|string|min:8|confirmed',
                                'password_confirmation' => 'required',
                                'agree_terms' =>  'required|in:agreed',
                                'g-recaptcha-response'  =>  'required|recaptcha',
                               
                            ]);
                            
                        }else{
                            $request->validate([
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|string|email|max:255|unique:customers',
                                'password' => 'required|string|min:8|confirmed',
                                'password_confirmation' => 'required',
                                'agree_terms' =>  'required|in:agreed',
                               
                            ]);
                        }
                    }
                }


    
                $geolocation = GeoIP::getLocation(request()->getClientIp());
                $user =  Customer::create([
                    'firstname' => $request->input('firstname'),
                    'lastname' => $request->input('lastname'),
                    'username' => $request->input('firstname') .' '. $request->input('lastname'),
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'userType' => 'Customer',
                    'country' => $geolocation->country,
                    'timezone' => $geolocation->timezone,
                    'status' => '1',
                    'image' => null,
                    
                ]);

                $customersetting = new CustomerSetting();
                $customersetting->custs_id = $user->id;
                $customersetting->darkmode = setting('DARK_MODE');
                $customersetting->save();
               
                $verifyUser = VerifyUser::create([
                    'cust_id' => $user->id,
                    'token' => sha1(time())
                ]);
                $verifyData = [
            
                    'username' => $user->username,
                    'email' => $user->email,
                    'email_verify_url' => route('verify.email',$verifyUser->token),
        
                ];
                try{
            
                    Mail::to($user->email)
                    ->send( new mailmailablesend( 'customer_sendmail_verification', $verifyData ) );
        
                
                }catch(\Exception $e){
                   
                    return redirect()->route('auth.login')->with('success', trans('langconvert.functions.newuserregister'));        
                }
                
                return redirect()->route('auth.login')->with('success', trans('langconvert.functions.newuserregister'));
            }
        }
        else{
    
            if(setting('CAPTCHATYPE') == 'off'){
                $request->validate([
                    'firstname' => 'required|max:255',
                    'lastname' => 'required|max:255',
                    'email' => 'required|string|email|max:255|unique:customers',
                    'password' => 'required|string|min:8|confirmed',
                    'password_confirmation' => 'required',
                    'agree_terms' =>  'required|in:agreed',
                ]);
            }else{
                if(setting('CAPTCHATYPE') == 'manual'){
                    if(setting('RECAPTCH_ENABLE_REGISTER')=='yes'){
                        $request->validate([
                            'firstname' => 'required|max:255',
                            'lastname' => 'required|max:255',
                            'email' => 'required|string|email|max:255|unique:customers',
                            'password' => 'required|string|min:8|confirmed',
                            'password_confirmation' => 'required',
                            'agree_terms' =>  'required|in:agreed',
                            'captcha' => ['required', 'captcha'],
                        ]);
                        
                    }else{
                        $request->validate([
                            'firstname' => 'required|max:255',
                            'lastname' => 'required|max:255',
                            'email' => 'required|string|email|max:255|unique:customers',
                            'password' => 'required|string|min:8|confirmed',
                            'password_confirmation' => 'required',
                            'agree_terms' =>  'required|in:agreed',
                            
                        ]);
                       
                    }
    
                }
                if(setting('CAPTCHATYPE') == 'google'){
                    if(setting('RECAPTCH_ENABLE_REGISTER')=='yes'){
                        $request->validate([
                            'firstname' => 'required|max:255',
                            'lastname' => 'required|max:255',
                            'email' => 'required|string|email|max:255|unique:customers',
                            'password' => 'required|string|min:8|confirmed',
                            'password_confirmation' => 'required',
                            'agree_terms' =>  'required|in:agreed',
                            'g-recaptcha-response'  =>  'required|recaptcha',
                           
                        ]);
                        
                    }else{
                        $request->validate([
                            'firstname' => 'required|max:255',
                            'lastname' => 'required|max:255',
                            'email' => 'required|string|email|max:255|unique:customers',
                            'password' => 'required|string|min:8|confirmed',
                            'password_confirmation' => 'required',
                            'agree_terms' =>  'required|in:agreed',
                           
                        ]);
                    }
                }
            }
            $geolocation = GeoIP::getLocation(request()->getClientIp());
                $user =  Customer::create([
                    'firstname' => $request->input('firstname'),
                    'lastname' => $request->input('lastname'),
                    'username' => $request->input('firstname') .' '. $request->input('lastname'),
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'userType' => 'Customer',
                    'country' => $geolocation->country,
                    'timezone' => $geolocation->timezone,
                    'status' => '1',
                    'image' => null,
                    
                ]);

                $customersetting = new CustomerSetting();
                $customersetting->custs_id = $user->id;
                $customersetting->save();
              
               
                $verifyUser = VerifyUser::create([
                    'cust_id' => $user->id,
                    'token' => sha1(time())
                ]);
                $verifyData = [
        
                    'username' => $user->username,
                    'email' => $user->email,
                    'email_verify_url' => route('verify.email',$verifyUser->token),
        
                ];
        
                try{
        
                    Mail::to($user->email)
                    ->send( new mailmailablesend( 'customer_sendmail_verification', $verifyData ) );
        
                
                }catch(\Exception $e){
                   
                    return redirect()->route('auth.login')->with('success', trans('langconvert.functions.newuserregister'));        
                }
                
                return redirect()->route('auth.login')->with('success', trans('langconvert.functions.newuserregister'));

        }
    }

    public function registers(Request $request)
    {
        $guest = Customer::where('email', '=', $request->email)->first();

        if(Customer::where('email', '=', $request->email)->exists()){
            if($guest->password == null && $guest->provider_id == null && $guest->userType == 'Guest'){


                if(setting('CAPTCHATYPE') == 'off'){
                    $validator = Validator::make($request->all(), [
                        'firstname' => 'required|max:255',
                        'lastname' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:customers',
                        'password' => 'required|min:8|confirmed',
                        'agree_terms' =>  'required|in:agreed',
                        
                    ]);
                }else{
                    if(setting('CAPTCHATYPE') == 'manual'){
                        if(setting('RECAPTCH_ENABLE_REGISTER')=='yes'){
                            $validator = Validator::make($request->all(), [
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|email|max:255|unique:customers',
                                'password' => 'required|min:8|confirmed',
                                'agree_terms' =>  'required|in:agreed',
                                'captcha' => ['required', 'captcha'],
                            ]);
                            
                            
                        }else{
                            $validator = Validator::make($request->all(), [
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|email|max:255|unique:customers',
                                'password' => 'required|min:8|confirmed',
                                'agree_terms' =>  'required|in:agreed',
                                
                            ]);
                           
                        }
        
                    }
                    if(setting('CAPTCHATYPE') == 'google'){
                        if(setting('RECAPTCH_ENABLE_REGISTER')=='yes'){
                            $validator = Validator::make($request->all(), [
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|email|max:255|unique:customers',
                                'password' => 'required|min:8|confirmed',
                                'agree_terms' =>  'required|in:agreed',
                                'g-recaptcha-response'  =>  'recaptcha',
                            ]);
                            
                        }else{
                            $validator = Validator::make($request->all(), [
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|email|max:255|unique:customers',
                                'password' => 'required|min:8|confirmed',
                                'agree_terms' =>  'required|in:agreed',
                                
                            ]);
                        }
                    }
                }
    
                $geolocation = GeoIP::getLocation(request()->getClientIp());
                $guest->firstname = $request->firstname;
                $guest->lastname = $request->lastname;
                $guest->username = $request->firstname .' '.$request->lastname;
                $guest->password = Hash::make($request->password);
                $guest->userType = 'Customer';
                $guest->country = $geolocation->country;
                $guest->timezone = $geolocation->timezone;
                $guest->update();
    
                $verifyUser = VerifyUser::create([
                    'cust_id' => $guest->id,
                    'token' => sha1(time())
                ]);
                $verifyData = [
        
                    'username' => $guest->username,
                    'email' => $guest->email,
                    'email_verify_url' => route('verify.email',$verifyUser->token),
        
                ];
        
                try{
        
                    Mail::to($guest->email)
                    ->send( new mailmailablesend( 'customer_sendmail_verification', $verifyData ) );
        
                
                }catch(\Exception $e){
                   
                    return Response::json(['success' => '1']);
                }
                
    
                return Response::json(['success' => '1']);
                
            }
            else{
                if(setting('CAPTCHATYPE') == 'off'){
                    $validator = Validator::make($request->all(), [
                        'firstname' => 'required|max:255',
                        'lastname' => 'required|max:255',
                        'email' => 'required|email|max:255|unique:customers',
                        'password' => 'required|min:8|confirmed',
                        'agree_terms' =>  'required|in:agreed',
                        
                    ]);
                }else{
                    if(setting('CAPTCHATYPE') == 'manual'){
                        if(setting('RECAPTCH_ENABLE_REGISTER')=='yes'){
                            $validator = Validator::make($request->all(), [
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|email|max:255|unique:customers',
                                'password' => 'required|min:8|confirmed',
                                'agree_terms' =>  'required|in:agreed',
                                'captcha' => ['required', 'captcha'],
                            ]);
                            
                            
                        }else{
                            $validator = Validator::make($request->all(), [
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|email|max:255|unique:customers',
                                'password' => 'required|min:8|confirmed',
                                'agree_terms' =>  'required|in:agreed',
                                
                            ]);
                           
                        }
        
                    }
                    if(setting('CAPTCHATYPE') == 'google'){
                        if(setting('RECAPTCH_ENABLE_REGISTER')=='yes'){
                            $validator = Validator::make($request->all(), [
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|email|max:255|unique:customers',
                                'password' => 'required|min:8|confirmed',
                                'agree_terms' =>  'required|in:agreed',
                                'g-recaptcha-response'  =>  'recaptcha',
                            ]);
                            
                        }else{
                            $validator = Validator::make($request->all(), [
                                'firstname' => 'required|max:255',
                                'lastname' => 'required|max:255',
                                'email' => 'required|email|max:255|unique:customers',
                                'password' => 'required|min:8|confirmed',
                                'agree_terms' =>  'required|in:agreed',
                                
                            ]);
                        }
                    }
                }

        
                if ($validator->passes()) {
        
                    // Store your user in database 
                    $geolocation = GeoIP::getLocation(request()->getClientIp());
                    $user =  Customer::create([
                        'firstname' => $request->input('firstname'),
                        'lastname' => $request->input('lastname'),
                        'username' => $request->input('firstname') .' '. $request->input('lastname'),
                        'email' => $request->email,
                        'password' => Hash::make($request->password),
                        'userType' => 'Customer',
                        'country' => $geolocation->country,
                        'timezone' => $geolocation->timezone,
                        'status' => '1',
                        'image' => null,
                        
                    ]);

                    $customersetting = new CustomerSetting();
                    $customersetting->custs_id = $user->id;
                    $customersetting->darkmode = setting('DARK_MODE');
                    $customersetting->save();

                $verifyUser = VerifyUser::create([
                    'cust_id' => $user->id,
                    'token' => sha1(time())
                ]);
                $verifyData = [
        
                    'username' => $user->username,
                    'email' => $user->email,
                    'email_verify_url' => route('verify.email',$verifyUser->token),
        
                ];
        
                try{
        
                    Mail::to($user->email)
                    ->send( new mailmailablesend( 'customer_sendmail_verification', $verifyData ) );
        
                
                }catch(\Exception $e){
                   
                    return Response::json(['success' => '1']);
                }
        
                    return Response::json(['success' => '1']);
        
                }
                
                return Response::json(['errors' => $validator->errors()]);
            }
        }
        else{

            if(setting('CAPTCHATYPE') == 'off'){
                $validator = Validator::make($request->all(), [
                    'firstname' => 'required|',
                    'lastname' => 'required|',
                    'email' => 'required|email|max:255|unique:customers',
                    'password' => 'required|min:8|confirmed',
                    'agree_terms' =>  'required|in:agreed',
                    
                ]);
            }else{
                if(setting('CAPTCHATYPE') == 'manual'){
                    if(setting('RECAPTCH_ENABLE_REGISTER')=='yes'){
                        $validator = Validator::make($request->all(), [
                            'firstname' => 'required|max:255',
                            'lastname' => 'required|max:255',
                            'email' => 'required|email|max:255|unique:customers',
                            'password' => 'required|min:8|confirmed',
                            'agree_terms' =>  'required|in:agreed',
                            'captcha' => ['required', 'captcha'],
                        ]);
                        
                        
                    }else{
                        $validator = Validator::make($request->all(), [
                            'firstname' => 'required|max:255',
                            'lastname' => 'required|max:255',
                            'email' => 'required|email|max:255|unique:customers',
                            'password' => 'required|min:8|confirmed',
                            'agree_terms' =>  'required|in:agreed',
                            
                        ]);
                       
                    }
    
                }
                if(setting('CAPTCHATYPE') == 'google'){
                    if(setting('RECAPTCH_ENABLE_REGISTER')=='yes'){
                        $validator = Validator::make($request->all(), [
                            'firstname' => 'required|max:255',
                            'lastname' => 'required|max:255',
                            'email' => 'required|email|max:255|unique:customers',
                            'password' => 'required|min:8|confirmed',
                            'agree_terms' =>  'required|in:agreed',
                            'grecaptcharesponse'  =>  'recaptcha',
                        ]);
                        
                    }else{
                        $validator = Validator::make($request->all(), [
                            'firstname' => 'required|max:255',
                            'lastname' => 'required|max:255',
                            'email' => 'required|email|max:255|unique:customers',
                            'password' => 'required|min:8|confirmed',
                            'agree_terms' =>  'required|in:agreed',
                            
                        ]);
                    }
                }
            }


            if ($validator->passes()) {
    
                // Store your user in database 
                $geolocation = GeoIP::getLocation(request()->getClientIp());
                $user =  Customer::create([
                    'firstname' => $request->input('firstname'),
                    'lastname' => $request->input('lastname'),
                    'username' => $request->input('firstname') .' '. $request->input('lastname'),
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'userType' => 'Customer',
                    'country' => $geolocation->country,
                    'timezone' => $geolocation->timezone,
                    'status' => '1',
                    'image' => null,
                    
                ]);

                $customersetting = new CustomerSetting();
                $customersetting->custs_id = $user->id;
                $customersetting->darkmode = setting('DARK_MODE');
                $customersetting->save();
            
                $verifyUser = VerifyUser::create([
                    'cust_id' => $user->id,
                    'token' => sha1(time())
                ]);
                $verifyData = [
        
                    'username' => $user->username,
                    'email' => $user->email,
                    'email_verify_url' => route('verify.email',$verifyUser->token),
        
                ];
    
                try{
        
                    Mail::to($user->email)
                    ->send( new mailmailablesend( 'customer_sendmail_verification', $verifyData ) );
        
                
                }catch(\Exception $e){
                
                    return Response::json(['success' => '1']);
                }
        
                    return Response::json(['success' => '1']);
        
                }
            
                return Response::json(['errors' => $validator->errors()]);
            }
    }

    public function verifyUser($token)
    {
        $verifyUser = VerifyUser::where('token', $token)->first();
        if($verifyUser->user != null){
            if(isset($verifyUser) ){
                $user = $verifyUser->user;
                if(!$user->verified) {
                    $verifyUser->user->verified = 1;
                    $verifyUser->user->save();
                    $status = trans('langconvert.functions.statusverified');
                } else {
                    $status = trans('langconvert.functions.statusalreadyverified');
                }
            } else {
                return redirect()->route('auth.login')->with('warning', trans('langconvert.functions.emailnotidentity'));
            }
            if(setting('REGISTER_POPUP') == 'yes'){
                return redirect('/')->with('success', $status);
            }else{
                return redirect()->route('auth.login')->with('success', $status);
            }
        }else {
            return redirect()->route('auth.login')->with('warning', trans('langconvert.functions.emailnotidentity'));
        }
        
    }
}
