<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Models\Seosetting;
use App\Models\Apptitle;
use Artisan;
use App\Models\passwordreset;
use Mail;
use App\Mail\mailmailablesend;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showLinkRequestForm(){

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $title = Apptitle::first();
        $data['title'] = $title;

        return view('admin.auth.passwords.forgotpassword')->with($data);
    }


    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {

        $request->validate([
            'email' => 'required|email|exists:users',
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

    

}
