<?php

namespace App\Http\Controllers\Contactform;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contactform\ContactUs;
use Mail;
use App\Mail\mailmailablesend;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\User;
use App\Models\SocialAuthSetting;

class ContactController extends Controller
{
    public function contact(){

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $socialAuthSettings = SocialAuthSetting::first();
        $data['socialAuthSettings'] = $socialAuthSettings;

        return view('contactform.contactus')->with($data) ;
    }

    public function saveContact(Request $request) { 

        if(setting('CAPTCHATYPE') == 'off'){
            $this->validate($request, [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'subject' => 'required|max:255',
                'phone_number' => 'required|numeric',
                'message' => 'required',
            ]);
        }else{
            if(setting('CAPTCHATYPE') == 'manual'){
                if(setting('RECAPTCH_ENABLE_CONTACT')=='yes'){
                    $this->validate($request, [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255',
                        'subject' => 'required|max:255',
                        'phone_number' => 'required|numeric',
                        'message' => 'required',
                        'captcha' => ['required', 'captcha'],
                        
                    ]);
                }else{
                    $this->validate($request, [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255',
                        'subject' => 'required|max:255',
                        'phone_number' => 'required|numeric',
                        'message' => 'required',
                    ]);  
                }

            }
            if(setting('CAPTCHATYPE') == 'google'){
                if(setting('RECAPTCH_ENABLE_CONTACT')=='yes'){
                    $this->validate($request, [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255',
                        'subject' => 'required|max:255',
                        'phone_number' => 'required|numeric',
                        'message' => 'required',
                        'g-recaptcha-response'  =>  'required|recaptcha',
                        
                    ]);
                }else{
                    $this->validate($request, [
                        'name' => 'required|max:255',
                        'email' => 'required|email|max:255',
                        'subject' => 'required|max:255',
                        'phone_number' => 'required|numeric',
                        'message' => 'required',
                    ]);  
                }
            }
        }
        
        $contactData = [
            'Contact_name' => $request->name,
            'Contact_email' => $request->email,
            'Contact_subject' => $request->subject,
            'Contact_phone' => $request->phone_number,
            'Contact_message' => $request->message,

        ];

        try{

            Mail::to($request->email)
            ->send( new mailmailablesend( 'customer_sendmail_contactus', $contactData ) );

            Mail::to( setting('mail_from_address') )
                ->send( new mailmailablesend( 'admin_sendmail_contactus', $contactData ) );
        
        }catch(\Exception $e){
           
            return back()->with('success', trans('langconvert.functions.contactpage'));        
        }
        
          return back()->with('success', trans('langconvert.functions.contactpage'));
    }
}
