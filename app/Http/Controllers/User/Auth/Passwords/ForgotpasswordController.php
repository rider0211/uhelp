<?php

namespace App\Http\Controllers\User\Auth\Passwords;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB; 
use Carbon\Carbon; 
use Mail;
use App\Mail\mailmailablesend;
use App\Models\Apptitle;
use App\Models\passwordreset;
use App\Models\Customer;
use App\Models\Seosetting;

class ForgotpasswordController extends Controller
{
    public function forgot(){

        $title = Apptitle::first();
        $data['title'] = $title;
        
        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;
        


        return view('user.auth.passwords.forgotpassword')->with($data);
    }

    public function Email(Request $request)
    {
        
        $request->validate([
            'email' => 'required|email|exists:customers',
        ]);
        $token = str_random(64);

        $reset = passwordreset::create([
            'email' => $request->email, 
            'token' => $token,
        ]);
        
        $verifyData = [

            'reset_password_url' => route('reset.password',$reset->token),

          ];

          try{

            Mail::to($reset->email)
            ->send( new mailmailablesend( 'forget_password', $verifyData ) );

        
        }catch(\Exception $e){
           
            return redirect('login')->with('success', 'Email Verfication link as successfully sent.Please Check the mail');        
        }
  
        return back()->with('success', 'We have e-mailed your password reset link!');
    }

    public function Emailajax(Request $request){

        $customerExist = Customer::where(['email' => $request->email])->exists();

        if($customerExist){
        $token = str_random(64);

        $reset = passwordreset::create([
            'email' => $request->email, 
            'token' => $token,
        ]);
        
        $verifyData = [

            'reset_password_url' => route('reset.password',$reset->token),

          ];

          try{

            Mail::to($reset->email)
            ->send( new mailmailablesend( 'forget_password', $verifyData ) );

        
        }catch(\Exception $e){
            return response()->json([ [1] ]);
                 
        }
        return response()->json([ [1] ]);
    }else{
        return response()->json([ [3] ]);
    }
    }
}
