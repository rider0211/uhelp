<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Models\Setting;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\EmailTemplate;
use App\Models\SocialAuthSetting;
use App\Http\Requests\SocialAuthRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailMailableSend;

class AdminSettingController extends Controller
{

    /**
     * Social Login Settings.
     *
     * @return \Illuminate\Http\Response
     */

    public function sociallogin() {
        $this->authorize('Social Logins Access');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $credentials = SocialAuthSetting::first();
        $data['credentials'] = $credentials;

        return view('admin.generalsetting.socialloginsetting')->with($data);
    }

    /**
     * Social Login Settings.
     *
     * @return \Illuminate\Http\Response
     */

    public function socialloginupdate(SocialAuthRequest $request) {
        
        $socialAuth = SocialAuthSetting::first();

        $socialAuth->twitter_client_id = $request->twitter_client_id;
        $socialAuth->twitter_secret_id = $request->twitter_secret_id;
        ($request->twitter_status) ? $socialAuth->twitter_status = 'enable' : $socialAuth->twitter_status = 'disable';

        $socialAuth->facebook_client_id = $request->facebook_client_id;
        $socialAuth->facebook_secret_id = $request->facebook_secret_id;
        ($request->facebook_status) ? $socialAuth->facebook_status = 'enable' : $socialAuth->facebook_status = 'disable';

        $socialAuth->google_client_id = $request->google_client_id;
        $socialAuth->google_secret_id = $request->google_secret_id;
        ($request->google_status)  ? $socialAuth->google_status = 'enable' : $socialAuth->google_status = 'disable';

        $socialAuth->envato_client_id = $request->envato_client_id;
        $socialAuth->envato_secret_id = $request->envato_secret_id;
        ($request->envato_status) ? $socialAuth->envato_status = 'enable' : $socialAuth->envato_status = 'disable';

        $socialAuth->save();

        return back()->with('success', trans('langconvert.functions.updatecommon'));
    }

    /**
     * Captcha Settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function captcha()
    {
        $this->authorize('Captcha Setting Access');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.generalsetting.captchasetting')->with($data);
    }

    /**
     * Captcha Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function captchastore(Request $request)
    {

        $this->validate($request, [
            'googlerecaptchakey' => 'required|max:10000',
            'googlerecaptchasecret' => 'required|max:10000',
        ]);
        $data['GOOGLE_RECAPTCHA_KEY'] = $request->googlerecaptchakey;
        $data['GOOGLE_RECAPTCHA_SECRET'] = $request->googlerecaptchasecret;

        $this->updateSettings($data);
        
        return back()->with('success',trans('langconvert.functions.updatecommon'));
    }

    public function captchatypestore(Request $request){

        $data['captchatype'] = $request->captchatype;
        $this->updateSettings($data);
        return response()->json(['success' => trans('langconvert.functions.updatecommon')]);
    }
    /**
     * Email Settings.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function email(){

        $this->authorize('Email Setting Access');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;


        return view('admin.email.email')->with($data);
        
    }
    /**
     * Ticket Settings.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function ticketsetting()
    {
        $this->authorize('Ticket Setting Access');

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;


        return view('admin.generalsetting.ticketsetting')->with($data);
        
    }

        /**
     * Ticket Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function ticketsettingstore(Request $request)
    {
        $request->validate([
            'ticketid' => 'required',
            
        ]);
        if($request->userreopentime){
            $request->validate([
                'userreopentime' => 'required|numeric|gte:0'
            ]);
        }
        if($request->autoclosetickettime){
            $request->validate([
                'autoclosetickettime' => 'required|numeric|gte:0'
            ]);
        }
        if($request->autooverduetickettime){
            $request->validate([
                'autooverduetickettime' => 'required|numeric|gte:0'
            ]);
        }
        if($request->autoresponsetickettime){
            $request->validate([
                'autoresponsetickettime' => 'required|numeric|gte:0'
            ]);
        }
        if($request->autonotificationdeletedays){
            $request->validate([
                'autonotificationdeletedays' => 'required|numeric|gte:0'
            ]);
        }
        
        $data['USER_REOPEN_ISSUE']  =  $request->has('USER_REOPEN_ISSUE') ? 'yes' : 'no';
        $data['USER_REOPEN_TIME']  =  $request->input('userreopentime') ;
        $data['AUTO_CLOSE_TICKET']  =  $request->has('AUTO_CLOSE_TICKET') ? 'yes' : 'no';
        $data['AUTO_CLOSE_TICKET_TIME']  =  $request->input('autoclosetickettime') ;
        $data['AUTO_OVERDUE_TICKET']  =  $request->has('AUTO_CLOSE_TICKET') ? 'yes' : 'no';
        $data['AUTO_OVERDUE_TICKET_TIME']  =  $request->input('autooverduetickettime');
        $data['AUTO_RESPONSETIME_TICKET']  =  $request->has('AUTO_RESPONSETIME_TICKET') ? 'yes' : 'no';
        $data['AUTO_RESPONSETIME_TICKET_TIME']  =  $request->input('autoresponsetickettime') ;
        $data['AUTO_NOTIFICATION_DELETE_ENABLE']  =  $request->has('AUTO_NOTIFICATION_DELETE_ENABLE') ? 'on' : 'off';
        $data['AUTO_NOTIFICATION_DELETE_DAYS']  =  $request->input('autonotificationdeletedays') ;
        $data['CUSTOMER_TICKETID']  =  $request->input('ticketid') ;
        $data['GUEST_TICKET']  =  $request->has('GUEST_TICKET') ? 'yes' : 'no';
        $data['PRIORITY_ENABLE']  =  $request->has('PRIORITY_ENABLE') ? 'yes' : 'no';
        $data['USER_FILE_UPLOAD_ENABLE']  =  $request->has('USER_FILE_UPLOAD_ENABLE') ? 'yes' : 'no';
        $data['GUEST_FILE_UPLOAD_ENABLE']  =  $request->has('GUEST_FILE_UPLOAD_ENABLE') ? 'yes' : 'no';

        $this->updateSettings($data);
        
        return back()->with('success', trans('langconvert.functions.updatecommon'));
    }
    /**
     * Email Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function emailStore(Request $request)
    {
       
        if($request->ajax()){
            
            if($request->mail_driver == 'sendmail'){
                $request->validate([
                    'mail_from_name' => 'required|max:10000',
                    'mail_from_address' => 'required|max:10000'
                ]);
            }
            if($request->mail_driver == 'smtp'){
                $request->validate([
                    'mail_host' => 'required|max:10000',
                    'mail_port' => 'required|numeric',
                    'mail_encryption' => 'required|max:10000',
                    'mail_username' => 'required|max:10000',
                    'mail_password' => 'required|max:10000',
                    'mail_from_name' => 'required|max:10000',
                    'mail_from_address' => 'required|max:10000'
                ]);
            }
            
            $data = $request->only(['mail_driver', 'mail_host', 'mail_port', 'mail_from_address', 'mail_from_name', 'mail_encryption', 'mail_username', 'mail_password']);
            
            $this->updateSettings($data);
            return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);
        }
    }

    /**
     * Email Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendTestMail(Request $request)
    {

        $email = $request->get('email');
        try{

            Mail::send('admin.email.template', [ 'emailBody' => "This is a test email sent by system" ], function($message) use ($email) {
            $message->to($email)->subject('Test Email');
            });
        
        return back()->with('success', trans('langconvert.functions.testemailsend'));
            
        
        }catch(\Exception $e){
          return back()->with('error',  trans('langconvert.functions.testemailsendno'));   
        }
        
    }


    /**
     * Email Settings.
     *
     * @return \Illuminate\Http\Response
     */

    public function emailtemplates(){
        $this->authorize('Email Template Access');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $emailtemplates = EmailTemplate::all();
        $data['emailtemplates'] = $emailtemplates;

        return view('admin.email.index')->with($data);
    }

     /**
     * Email Settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function emailtemplatesEdit($id)
    {
        $this->authorize('Email Template Edit');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $template = EmailTemplate::find($id);
        $data['template'] = $template;

        return view('admin.email.edit')->with($data);
    }

    public function emailtemplatesUpdate(Request $request, $id){

        $request->validate([
            'subject' => 'required|max:255',
            'body' => 'required'
        ]);

        $template = EmailTemplate::find($id)->update($request->only(['subject', 'body']));
        
        return redirect('/admin/emailtemplates')->with('success', trans('langconvert.functions.updatecommon'));
        
    }

    public function registerpopup(Request $request)
    {
         
          $data['REGISTER_POPUP'] = $request->status;
          $data['REGISTER_DISABLE'] = $request->registerdisable;
          $data['GOOGLEFONT_DISABLE'] = $request->googledisable;
          $data['FORCE_SSL'] = $request->forcessl;
          $data['DARK_MODE'] = $request->darkmode;
          $data['SPRUKOADMIN_P'] = $request->sprukoadminp;
          $data['SPRUKOADMIN_C'] = $request->sprukocustp;
          $data['ENVATO_ON'] = $request->envatoon;
          $data['ENVATO_EXPIRED_BLOCK'] = $request->envatoexpiredon;
          $data['purchasecode_on'] = $request->purchasecodeon;
          $data['defaultlogin_on'] = $request->defaultloginon;
          $this->updateSettings($data);
          

    return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);

    }


    public function filesettingstore(Request $request){

        $request->validate([
            'fileuploadmax' => 'required|numeric|gt:0',
            'fileuploadtypes' => 'required'
        ]);
        
        $data['MAX_FILE_UPLOAD']  =  $request->input('maxfileupload') ;
        $data['FILE_UPLOAD_MAX']  =  $request->input('fileuploadmax') ;
        $data['FILE_UPLOAD_TYPES']  =  $request->input('fileuploadtypes') ;

        $this->updateSettings($data);
        
        return back()->with('success', __('messages.langconvert.functions.updatecommon'));
    }


    public function knowledge(Request $request)
    {
        
        $data['KNOWLEDGE_ENABLE']  =  $request->KNOWLEDGE_ENABLE;
        $data['FAQ_ENABLE']  =  $request->FAQ_ENABLE;
        $data['CONTACT_ENABLE']  =  $request->CONTACT_ENABLE;
        
        $this->updateSettings($data);

        
        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);
    }

    public function profileuser(Request $request)
    {
        
        $data['PROFILE_USER_ENABLE']  =  $request->PROFILE_USER_ENABLE;
        
        $this->updateSettings($data);

        
        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);
    }
    public function profileagent(Request $request)
    {
        
        $data['PROFILE_AGENT_ENABLE']  =  $request->PROFILE_AGENT_ENABLE;
        
        $this->updateSettings($data);

        
        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);
    }

    public function captchacontact(Request $request)
    {
        
        $data['RECAPTCH_ENABLE_CONTACT']  =  $request->RECAPTCH_ENABLE_CONTACT;
        
        $this->updateSettings($data);

        
        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);
    }

    public function captcharegister(Request $request)
    {
        
        $data['RECAPTCH_ENABLE_REGISTER']  =  $request->RECAPTCH_ENABLE_REGISTER;
        
        $this->updateSettings($data);

        
        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);
    }
    public function captchalogin(Request $request)
    {
        
        $data['RECAPTCH_ENABLE_LOGIN']  =  $request->RECAPTCH_ENABLE_LOGIN;
        
        $this->updateSettings($data);

        
        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);
    }

    public function captchaguest(Request $request)
    {
        
        $data['RECAPTCH_ENABLE_GUEST']  =  $request->RECAPTCH_ENABLE_GUEST;
        
        $this->updateSettings($data);

        
        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);
    }


    /**
     * Frontend Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function frontendStore(Request $request)
    {

        $request->validate([
            'theme_color' => 'required',
            'theme_color_dark' => 'required',
        ]);

        $data = $request->only(['theme_color', 'theme_color_dark']);

        $this->updateSettings($data);
        
        return back()->with('success',  trans('langconvert.functions.updatecommon'));
    }


    public function googleanalytics()
    {
        $this->authorize('Google Analytics Access');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;
          

        return view('admin.generalsetting.googleanalytics')->with($data);

    }

    /**
     * Googleanalytics Settings Save/Update.
     *
     * @return \Illuminate\Http\Response
     */
    public function googleanalyticsStore(Request $request)
    {

        $request->validate([
            'GOOGLE_ANALYTICS' => 'required',
        ]);
        $data['GOOGLE_ANALYTICS_ENABLE']  =  $request->has('GOOGLE_ANALYTICS_ENABLE') ? 'yes' : 'no';
        $data['GOOGLE_ANALYTICS'] = $request->input(['GOOGLE_ANALYTICS']);

        $this->updateSettings($data);
        
        return back()->with('success', trans('langconvert.functions.updatecommon'));
    }

    public function languagesettingstore(Request $request){

        $data = $request->only(['default_lang']);

        $this->updateSettings($data);
        
        return back()->with('success', trans('langconvert.functions.updatecommon'));

    }
    
    public function seturl(Request $request)
    {

        $request->validate([
            'terms_url' => 'required',
        ]);

        $data = $request->only(['terms_url']);

        $this->updateSettings($data);
        
        return back()->with('success',  trans('langconvert.functions.updatecommon'));
      
    }

    public function datetimeformatstore(Request $request)
    {

        $data['date_format']= $request->date_format;
        $data['time_format'] = $request->time_format;

        $this->updateSettings($data);
        
        return back()->with('success', trans('langconvert.functions.updatecommon'));

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
}
