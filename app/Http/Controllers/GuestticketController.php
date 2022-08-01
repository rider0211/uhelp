<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ticket\Ticket;
use App\Models\Ticket\Comment;
use App\Models\Ticket\Category;
use App\Models\Articles\Article;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\Apptitle;
use App\Models\Customer;
use App\Models\CustomerSetting;
use App\Models\User;
use App\Models\usersettings;
use App\Models\SocialAuthSetting;
use Mail;
use App\Mail\mailmailablesend;
use Hash;
use App\Models\Projects;
use Auth;
use App\Notifications\TicketCreateNotifications;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use GeoIP;
use Modules\Uhelpupdate\Entities\APIData;
use Modules\Uhelpupdate\Entities\CategoryEnvato;
use App\Models\VerifyOtp;
use App\Models\Subcategorychild;

class GuestticketController extends Controller
{
    public function index()
    {


        $tickets = Ticket::paginate(10);
        $categories = Category::whereIn('display',['ticket', 'both'])->where('status', '1')
        ->get();
        $data['categories'] = $categories;

        $title = Apptitle::first();
        $data['title'] = $title;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $socialAuthSettings = SocialAuthSetting::first();
        $data['socialAuthSettings'] = $socialAuthSettings;

        $recentarticles = Article::latest()->paginate(5);
        $data['recentarticles'] = $recentarticles;

        $populararticle = Article::orderBy('views','desc')->latest()->paginate(5);
        $data['populararticles'] = $populararticle;

        return view('guestticket.index', compact('tickets', 'categories'))->with($data);
        
    }

    // Guest Ticket Creating
    public function gueststore(Request $request)
    {

        if(setting('CAPTCHATYPE') == 'off'){
            $this->validate($request, [
                'subject' => 'required|max:255',
                'category' => 'required',
                'message' => 'required',
                'email' => 'required|max:255',
                
            ]);
        }else{
            if(setting('CAPTCHATYPE') == 'manual'){
                if(setting('RECAPTCH_ENABLE_GUEST')=='yes'){
                    $request->validate([
                        'subject' => 'required|max:255',
                        'category' => 'required',
                        'message' => 'required',
                        'email' => 'required|max:255',
                        'captcha' => ['required', 'captcha'],
                    ]);
                    
                }else{
                    $request->validate([
                        'subject' => 'required|max:255',
                        'category' => 'required',
                        'email' => 'required|max:255',
                        'message' => 'required',
                        
                    ]);
                   
                }

            }
            if(setting('CAPTCHATYPE') == 'google'){
                if(setting('RECAPTCH_ENABLE_GUEST')=='yes'){
                    $request->validate([
                        'subject' => 'required|max:255',
                        'category' => 'required',
                        'message' => 'required',
                        'email' => 'required|max:255',
                        'g-recaptcha-response'  =>  'required|recaptcha',
                       
                    ]);
                    
                }else{
                    $request->validate([
                        'subject' => 'required|max:255',
                        'category' => 'required',
                        'email' => 'required|max:255',
                        'message' => 'required',
                       
                    ]);
                }
            }
        }

        $otpverify = VerifyOtp::where('otp', $request->verifyotp)->first();
        if($otpverify){
            $guest = Customer::where('email', $request->email)->first();
            $ticket = Ticket::create([
                'subject' => $request->input('subject'),
                'cust_id' => $guest->id,
                'category_id' => $request->input('category'),
                'priority' => $request->input('priority'),
                'message' => $request->input('message'),
                'project' => $request->input('project'),
                'status' => 'New',
            ]);
            $ticket = Ticket::find($ticket->id);
            $ticket->ticket_id = setting('CUSTOMER_TICKETID').'G-'.$ticket->id;
            $ticket->auto_overdue_ticket = now()->addDays(setting('AUTO_OVERDUE_TICKET_TIME'));
            if($request->input('envato_id')){
                
                $ticket->purchasecode = $request->input('envato_id');
            }
            if($request->input('envato_support')){
                
                $ticket->purchasecodesupport = $request->input('envato_support');
            }
            $categoryfind = Category::find($request->category);
            $ticket->priority = $categoryfind->priority;
            if($request->subscategory){
                $ticket->subcategory = $request->subscategory;
            }
            $ticket->update();
            $geolocation = GeoIP::getLocation(request()->getClientIp());
            $custupdate = Customer::find($ticket->cust_id);
            $custupdate->last_login_ip = $geolocation->ip;
            $custupdate->timezone = $geolocation->timezone;
            $custupdate->country = $geolocation->country;
            $custupdate->update();
            foreach ($request->input('ticket', []) as $file) {
                $ticket->addMedia(public_path('uploads/guestticket/' . $file))->toMediaCollection('ticket');
            }
            // Create a New ticket reply
            $notificationcat = $ticket->category->groupscategoryc()->get();
            $icc = array();
            if($notificationcat->isNotEmpty()){
    
                foreach($notificationcat as $igc){
                        
                    foreach($igc->groupsc->groupsuser()->get() as $user){
                        $icc[] .= $user->users_id;
                    }
                }
                
                if(!$icc){
                    $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                    foreach($admins as $admin){
                        $admin->notify(new TicketCreateNotifications($ticket));
                    }
                    
                }else{
                    
                    $user = User::whereIn('id', $icc)->get();
                    foreach($user as $users){
                        $users->notify(new TicketCreateNotifications($ticket));
                    }
                    $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                    foreach($admins as $admin){
                        $admin->notify(new TicketCreateNotifications($ticket));
                    }
                    
                    
                }
            }else{
                $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                foreach($admins as $admin){
                    $admin->notify(new TicketCreateNotifications($ticket));
                }
            }

            $verifyUser = VerifyOtp::where('otp', $request->verifyotp)->first();
            $verifyUser->delete();
            
            $ticketData = [
                'ticket_username' => $ticket->cust->username,
                'ticket_title' => $ticket->subject,
                'ticket_description' => $ticket->message,
                'ticket_customer_url' => route('gusetticket', $ticket->ticket_id),
                'ticket_admin_url' => url('/admin/ticket-view/'.$ticket->ticket_id),
            ];
            try{

                Mail::to($ticket->cust->email)
                ->send( new mailmailablesend( 'customer_send_guestticket_created', $ticketData ) );

                Mail::to(setting('mail_from_address') )
                    ->send( new mailmailablesend( 'admin_send_email_ticket_created', $ticketData ) );
            
            }catch(\Exception $e){
                
                return response()->json(['guest' => 'pass', 'data' => $ticket,  'success' => trans('langconvert.functions.ticketcreate'). $ticket->ticket_id], 200);
            }

            return response()->json(['guest' => 'pass', 'data' => $ticket,  'success' => trans('langconvert.functions.ticketcreate'). $ticket->ticket_id], 200);
        }
        if(!$otpverify){
            return response()->json(['guest' => 'invaildotp',  'success' => trans('langconvert.functions.invaliddata')], 200);
        }
    }

    public function guestdetails($id)
    {

        $ticket = Ticket::find($id);
        $data['ticket'] = $ticket;

        $title = Apptitle::first();
        $data['title'] = $title;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;
        
        $socialAuthSettings = SocialAuthSetting::first();
        $data['socialAuthSettings'] = $socialAuthSettings;

        return view('guestticket.viewticketdetails')->with($data);

    }

    public function guestmedia(Request $request)
    {
        $path = public_path('uploads/guestticket/');

        if (!file_exists($path)) {
            mkdir($path, 0777, true);
        }

        $file = $request->file('file');

        $name = uniqid() . '_' . trim($file->getClientOriginalName());

        $file->move($path, $name);

        return response()->json([
            'name'          => $name,
            'original_name' => $file->getClientOriginalName(),
        ]);
    }

    public function guestview($ticket_id)
    {

        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $comments = $ticket->comments()->paginate(5);
        $category = $ticket->category;

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

        return view('guestticket.show',compact('ticket','category', 'comments'))->with($data);

    }


    public function postComment(Request $request,  $ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        if($ticket->status == "Closed"){
            
            return redirect()->back()->with("error", trans('langconvert.functions.ticketalreadyclosed'));
        }
        else{
            $this->validate($request, [
                'comment' => 'required'
            ]);
            $comment = Comment::create([
                'ticket_id' => $request->input('ticket_id'),
                'cust_id' => $ticket->cust->id,
                'user_id' => null,
                'comment' => $request->input('comment')
            ]);
            $geolocation = GeoIP::getLocation(request()->getClientIp());
            $custupdate = Customer::find($ticket->cust_id);
            $custupdate->last_login_ip = $geolocation->ip;
            $custupdate->timezone = $geolocation->timezone;
            $custupdate->country = $geolocation->country;
            $custupdate->update();

            foreach ($request->input('comments', []) as $file) {
                $comment->addMedia(public_path('uploads/guestticket/' . $file))->toMediaCollection('comments');
            }

            // Closing the ticket
            
            if(request()->has(['status'])){

                $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

                $ticket->status = $request->input('status');
                $ticket->closing_ticket = now()->format('Y-m-d');
                $ticket->update();

                $ticketOwner = $ticket->user;

            }

            $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
            $ticket->last_reply = now();
            // Auto Overdue Ticket

            if(setting('AUTO_OVERDUE_TICKET') == 'no'){
                $ticket->auto_overdue_ticket = null;
            }else{
                if(setting('AUTO_OVERDUE_TICKET_TIME') == '0'){
                    $ticket->auto_overdue_ticket = null;
                }else{
                    if(Auth::guard('customer')->check() && Auth::guard('customer')->user()){
                        if($ticket->status == 'Closed'){
                            $ticket->auto_overdue_ticket = null;
                        }
                        else{
                            $ticket->auto_overdue_ticket = now()->addDays(setting('AUTO_OVERDUE_TICKET_TIME'));
                        }
                    } 
                }
            }
            // Auto Overdue Ticket

            // Auto Closing Ticket

            if(setting('AUTO_CLOSE_TICKET') == 'no'){
                $ticket->auto_close_ticket = null;
            }else{
                if(setting('AUTO_CLOSE_TICKET_TIME') == '0'){
                    $ticket->auto_close_ticket = null;
                }else{
                    
                    if(Auth::guard('customer')->check() && Auth::guard('customer')->user()){
                        $ticket->auto_close_ticket = null;
                    }
                }
            }
            // End Auto Close Ticket

            if(request()->input(['status']) == 'Closed'){
                $ticket->replystatus = 'Solved';
            }
            $ticket->update();
            
            if(request()->input(['status']) == 'Closed'){
                // Create a New ticket reply
                $notificationcat = $ticket->category->groupscategoryc()->get();
                $icc = array();
                if($notificationcat->isNotEmpty()){
        
                    foreach($notificationcat as $igc){
                            
                        foreach($igc->groupsc->groupsuser()->get() as $user){
                            $icc[] .= $user->users_id;
                        }
                    }
                    
                    if(!$icc){
                        $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                        foreach($admins as $admin){
                            $admin->notify(new TicketCreateNotifications($ticket));
                        }
                        
                    }else{
                        
                        $user = User::whereIn('id', $icc)->get();
                        foreach($user as $users){
                            $users->notify(new TicketCreateNotifications($ticket));
                        }
                        $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                        foreach($admins as $admin){
                            $admin->notify(new TicketCreateNotifications($ticket));
                        }
                        
                        
                    }
                }else{
                    $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                    foreach($admins as $admin){
                        $admin->notify(new TicketCreateNotifications($ticket));
                    }
                }

                return redirect()->route('guest.rating', $ticket->ticket_id);
            }else{

                // Create a New ticket reply
                $notificationcat = $ticket->category->groupscategoryc()->get();
                $icc = array();
                    if($notificationcat->isNotEmpty()){

                        foreach($notificationcat as $igc){
                                
                            foreach($igc->groupsc->groupsuser()->get() as $user){
                                $icc[] .= $user->users_id;
                            }
                        }
                        
                        if(!$icc){
                            $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                            foreach($admins as $admin){
                                $admin->notify(new TicketCreateNotifications($ticket));
                            }
                            
                        }else{
                        
                            $user = User::whereIn('id', $icc)->get();
                            foreach($user as $users){
                                $users->notify(new TicketCreateNotifications($ticket));
                            }
                            $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                            foreach($admins as $admin){
                                $admin->notify(new TicketCreateNotifications($ticket));
                            }
                            
                            
                        }
                    }else{
                        $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                        foreach($admins as $admin){
                            $admin->notify(new TicketCreateNotifications($ticket));
                        }
                    }

                return redirect()->back()->with("success", trans('langconvert.functions.ticketreply'));
            }
        }
       
    }

    public function envatoverify(Request $request)
    {
        if($request->data){

            $apidatatoken = APIData::first();

            $envato_license = $request->data;

            $url = "https://api.envato.com/v3/market/author/sale?code=".$envato_license;
            $curl = curl_init($url);
  
            $personal_api_token = $apidatatoken != null ? $apidatatoken->envatoapitoken : '';
  
            /*Correct header for the curl extension*/
            $header = array();
            $header[] = 'Authorization: Bearer '.$personal_api_token;
            $header[] = 'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10.11; rv:41.0) Gecko/20100101 Firefox/41.0';
            $header[] = 'timeout: 20';
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER,$header);
            
            /*Connect to the API, and get values from there*/
            $envatoCheck = curl_exec($curl);
            curl_close($curl);
  
            
            $envatoCheck = json_decode($envatoCheck);

            /*Variable request from the API*/
            $date = new \DateTime(isset($envatoCheck->supported_until) ? $envatoCheck->supported_until : false);							
            $support_date = $date->format('Y-m-d H:i:s');
            $sold = new \DateTime(isset($envatoCheck->sold_at) ? $envatoCheck->sold_at : false);
            $sold_at = $sold->format('Y-m-d H:i:s');
            $buyer = (isset( $envatoCheck->buyer) ? $envatoCheck->buyer : false);
            $license = (isset( $envatoCheck->license) ? $envatoCheck->license : false);
            $count = (isset( $envatoCheck->purchase_count) ? $envatoCheck->purchase_count : false);
            $support_amount = (isset( $envatoCheck->support_amount) ? $envatoCheck->support_amount : false);
            $item  = (isset( $envatoCheck->item->previews->landscape_preview->landscape_url ) ? $envatoCheck->item->previews->landscape_preview->landscape_url  : false);

             /*If Purchase code exists, But Purchase ended*/
             if (isset($envatoCheck->item->name)  && (date('Y-m-d H:i:s') >= $support_date))
             { 
                 return response()->json(['valid' => 'expried', 'message' => 'The purchase code has been verified, but your product support has expired.']);
                 
             }
 
             /*If Purchase code exists, display client information*/
             if (isset($envatoCheck->item->name)  && (date('Y-m-d H:i:s') < $support_date))
             { 
                 return response()->json(['valid' => 'true', 'message' => 'The purchase code has been validated and is supported.']);
             }
 
             /*If Purchase Code doesn't exist,*/
             if (!isset($envatoCheck->item->name)){ 
                 return response()->json(['valid' => 'false', 'message' =>'The Purchase Code is invalid.']);
             }
           

            
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function rating($ticket_id)
    {
        
        $ticket = Ticket::where('ticket_id',$ticket_id)->first();
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

        $rating = $ticket->comments()->whereNotNull('user_id')->get();
        $comment = Comment::select('user_id')->where('ticket_id',  $ticket->id)->distinct()->get();

        if($rating->isEmpty()){
            return redirect()->back()->with("success", "Your comment has be submitted.");
        }
        else{
            return view('guestticket.rating', compact('ticket','title', 'comment', 'footertext'))->with($data);
        }
  
    }

    /// rating system ///
    public function star5($id)
    {

        $user = User::with('usetting')->findorFail($id);
        $user->usetting->increment('star5');
        $user->usetting->update();
        
        return redirect('/')->with('success', trans('langconvert.functions.ratingsubmit'));
       
    }

    public function star4($id)
    {

        $user = User::with('usetting')->findorFail($id);
        $user->usetting->increment('star4');
        $user->usetting->update();

        return redirect('/')->with('success', trans('langconvert.functions.ratingsubmit'));
       
    }

    public function star3($id)
    {

        $user = User::with('usetting')->findorFail($id);
        $user->usetting->increment('star3');
        $user->usetting->update();

        return redirect('/')->with('success', trans('langconvert.functions.ratingsubmit'));
       
    }


    public function star2($id)
    {

        $user = User::with('usetting')->findorFail($id);
        $user->usetting->increment('star2');
        $user->usetting->update();

        return redirect('/')->with('success', trans('langconvert.functions.ratingsubmit'));
       
    }

    public function star1($id)
    {

        $user = User::with('usetting')->findorFail($id);
        $user->usetting->increment('star1');
        $user->usetting->update();

        return redirect('/')->with('success', trans('langconvert.functions.ratingsubmit'));
    }
    /// end rating system ///

    public function imagedestroy($id)
    {   
        //For Deleting Users
        $commentss = Media::findOrFail($id);
        $commentss->delete();
        return response()->json([
            'success' => trans('langconvert.functions.ticketimagedelete')
        ]);
    }


    public function close(Request $request,$ticket_id)
    {

        
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status = 'Re-Open';

        $ticket->update();

        // Create a New ticket reply
        $notificationcat = $ticket->category->groupscategoryc()->get();
        $icc = array();
            if($notificationcat->isNotEmpty()){

                foreach($notificationcat as $igc){
                        
                    foreach($igc->groupsc->groupsuser()->get() as $user){
                        $icc[] .= $user->users_id;
                    }
                }
                
                if(!$icc){
                    $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                    foreach($admins as $admin){
                        $admin->notify(new TicketCreateNotifications($ticket));
                    }
                    
                }else{
                
                    $user = User::whereIn('id', $icc)->get();
                    foreach($user as $users){
                        $users->notify(new TicketCreateNotifications($ticket));
                    }
                    $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                    foreach($admins as $admin){
                        $admin->notify(new TicketCreateNotifications($ticket));
                    }
                    
                    
                }
            }else{
                $admins = User::leftJoin('groups_users','groups_users.users_id','users.id')->whereNull('groups_users.groups_id')->whereNull('groups_users.users_id')->get();
                foreach($admins as $admin){
                    $admin->notify(new TicketCreateNotifications($ticket));
                }
            }

        $ticketData = [
            'ticket_title' => $ticket->subject,
            'ticket_description' => $ticket->message,
            'ticket_status' => $ticket->status,
            'ticket_customer_url' => route('loadmore.load_data', $ticket->ticket_id),
            'ticket_admin_url' => url('/admin/ticket-view/'.$ticket->ticket_id),
        ];

        try{

            Mail::to(setting('mail_from_address') )
            ->send( new mailmailablesend( 'customer_send_ticket_reopen', $ticketData ) );

            
        
        }catch(\Exception $e){
            return redirect()->back()->with("success", trans('langconvert.functions.ticketreopen'));
        }

        return redirect()->back()->with("success", trans('langconvert.functions.ticketreopen'));
                
    }

    public function emailsvalidateguest(Request $request)
    {
       
        $customerfind = Customer::where('email', $request->email)->first();
        if($customerfind){
            if($customerfind->userType == 'Guest'){

                $guest = Customer::where('email', $request->email)->first();
                $verifyOtp = VerifyOtp::create([
                    'cust_id' => $guest->id,
                    'otp' => rand(1000, 9999),
                ]);
                
                $guestticket = [

                    'token' => $verifyOtp->otp,
                    'guestname' => $guest->username,
                    'guestemail' => $guest->email,
                ];

                try{

                    Mail::to($guest->email)
                    ->send( new mailmailablesend( 'guestticket_email_verification', $guestticket));
            
                       
                    
                }catch(\Exception $e){
                    return response()->json(['success' => 'Please check your Email', 'email' => 'exists']);
                }

                return response()->json(['success' => 'Please check your Email', 'email' => 'exists']);
            }
            if($customerfind->userType == 'Customer'){

                return response()->json(['error' => 'Email is already registered, Please login to Create a Ticket', 'email' => 'already']);
            }
           
        }
        if(!$customerfind){
            $guest = Customer::create([

                'firstname' => '',
                'lastname' => '',
                'username' => 'GUEST',
                'email' => $request->email,
                'userType' => 'Guest',
                'password' => null,
                'status' => '1',
                'image' => null,

            ]);
            $customersetting = new CustomerSetting();
            $customersetting->custs_id = $guest->id;
            $customersetting->save();

            $verifyOtp = VerifyOtp::create([
                'cust_id' => $guest->id,
                'otp' => rand(1000, 9999),
            ]);
            
            $guestticket = [

                'token' => $verifyOtp->otp,
                'guestname' => $guest->username,
                'guestemail' => $guest->email,
            ];

            try{

                Mail::to($guest->email)
                ->send( new mailmailablesend( 'guestticket_email_verification', $guestticket));
        
                
            }catch(\Exception $e){
                    
                return response()->json(['success' => 'Please check your Email', 'email' => 'exists']);
            }

            return response()->json(['success' => 'Please check your Email', 'email' => 'exists']);
        }

    }

    public function verifyotp(Request $request)
    {
        $verify = VerifyOtp::where('otp', $request->otpvalue)->first();

        if($verify)
        {
            return response()->json(['success' => 'verified'],200);
        }
        if(!$verify)
        {
            return response()->json(['error' => 'Not Verified'], 200);
        }
    }

    public function subcategorylist(Request $request)
    {

        $parent_id = $request->cat_id;
        
        $subcategoriess = Subcategorychild::where('category_id',$parent_id)->get();
        
        $output = '';
        if($subcategoriess->isNotEmpty()){
            $output .= '<option label="select subcategory"></option>';
            foreach($subcategoriess as $subcats){
                $sucatss = $subcats->subcatlists()->where('status', '1')->get();
                if($sucatss->isNotEmpty()){
                    foreach($sucatss as $subcategory){
                        
                        $output .= '<option value="'.$subcategory->id.'">'.$subcategory->subcategoryname.'</option>';
                    }
                }

            }
        }


        //projectlist
        $subcategories =Projects::select('projects.*','projects_categories.category_id')->join('projects_categories','projects_categories.projects_id', 'projects.id')
        ->where('projects_categories.category_id',$parent_id)
        ->get();

        // envato asssign

        $categoryenvato = CategoryEnvato::where('category_id', $parent_id)->get();
        
        $data = [
            'subcategoriess' => $output,
            'subcategories' => $subcategories,
            'envatosuccess' => $categoryenvato,
        ];
        return response()->json($data
        , 200);
    }
}
