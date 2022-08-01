<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\Comment;
use App\Models\Ticket\Category;
use App\Mail\AppMailer;
use App\Models\Customer;
use App\Models\User;
use App\Models\Role;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use DB;
use Mail;
use App\Mail\mailmailablesend;
use Hash;
use App\Models\Ticketnote;
use App\Models\Projects;
use App\Notifications\TicketCreateNotifications;
use App\Models\CustomerSetting;
use DataTables;
use App\Models\Groupsusers;
use Str;
use Modules\Uhelpupdate\Entities\Cannedmessages;

class AdminTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $tickets = Ticket::paginate(10);
            $categories = Category::all();

            $title = Apptitle::first();
            $data['title'] = $title;

            $footertext = Footertext::first();
            $data['footertext'] = $footertext;

            $seopage = Seosetting::first();
            $data['seopage'] = $seopage;

            $post = Pages::all();
            $data['page'] = $post;
       
           
    
            return view('admin.viewticket.showticket', compact('tickets', 'categories', 'title'))->with($data);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($ticket_id)
    {
        $this->authorize('Ticket Edit');
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $comments = $ticket->comments()->latest()->paginate(10);
        
        $category = $ticket->category;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $cannedmessage = Cannedmessages::where('status', '1')->get();
        $data['cannedmessages'] = $cannedmessage;

        if (request()->ajax()) {
            
            $view = view('admin.viewticket.showticketdata',compact('comments'))->render();
            return response()->json(['html'=>$view]);
        }
       
        return view('admin.viewticket.showticket', compact('ticket','category', 'comments', 'title','footertext'))->with($data);
    }


    public function commentshow($ticket_id){

        if(request()->ajax()){
            $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
            if(request()->id > 0){
                $comments = $ticket->comments()->where('id', '<', request()->id)
                ->orderBy('id', 'DESC')
                ->limit(6)
                ->latest()
                ->get();
            }else{
                $comments = $ticket->comments()
                ->orderBy('id', 'DESC')
                ->limit(6)
                ->latest()
                ->get();
            }
            
            $output = '';
            $last_id = '';
            $i = 0; 
            $len = count($comments); 
            if(!$comments->isEmpty())
            {
            foreach($comments as $comment){
                if($comment->user_id != null){
            
                    if($i == 0){
                        $output .= '
                        <div class="card-body">
                            <div class="d-sm-flex">
                                <div class="d-flex me-3">
                                    <a href="#">';
                                        if($comment->user != null){
                                            if ($comment->user->image == null){
                                                $output .= '<img src="'.asset('uploads/profile/user-profile.png').'"  class="media-object brround avatar-lg" alt="default">';
                                            }else{
                                                $output .= '<img class="media-object brround avatar-lg" alt="'.$comment->user->image.'" src="'.asset('uploads/profile/'. $ticket->user->image).'">';
                                            }
                                        }else{
                                            $output .= '<img src="'.asset('uploads/profile/user-profile.png').'"  class="media-object brround avatar-lg" alt="default">';
                                        }
                                        $output .= 
                                    '</a>
                                </div>
                                <div class="media-body">';
                                    if($comment->user != null){
                                        $output .= '<h5 class="mt-1 mb-1 font-weight-semibold">'.$comment->user->name.'<span class="badge badge-primary-light badge-md ms-2">'.$comment->user->getRoleNames()[0].'</span></h5>';
                                    }else{
                                        $output .= '<h5 class="mt-1 mb-1 font-weight-semibold text-muted">~</h5>';
                                    }
                                    $output .= '<small class="text-muted"><i class="feather feather-clock"></i> '.$comment->created_at->diffForHumans().'</small>
                                    <span class="fs-13 mb-0 mt-1" value="">
                                        '.$comment->comment.'
                                    </span>
                                    <div class="editsupportnote-icon animated" id="supportnote-icon-'.$comment->id.'">
                                        <form action="'.url('admin/ticket/editcomment/'.$comment->id).'" method="POST">
                                            '.csrf_field().'
                                            <textarea class="editsummernote" name="editcomment">'.$comment->comment.'</textarea>
                                            <div class="btn-list mt-1">
                                                <input type="submit" class="btn btn-secondary" onclick="this.disabled=true;this.form.submit();" value="Update">
                                            </div>
                                        </form>
                                    </div>
                                    ';
                                    if(Auth::id() == $comment->user_id){
                                        $output .= '<div class="row galleryopen">';
                                            foreach ($comment->getMedia('comments') as $commentss){
                                                $output .= '<div class="file-image-1  removespruko'.$commentss->id.'" id="imageremove'.$commentss->id.'">
                                                    <div class="product-image  ">
                                                        <a href="'.$commentss->getFullUrl().'" class="imageopen">
                                                            <img src="'.$commentss->getFullUrl().'" class="br-5" alt="'.$commentss->file_name.'">
                                                        </a>
                                                        <ul class="icons">
                                                            <li><a href="javascript:(0);" class="bg-danger " onclick="deleteticket(event.target)" data-id="'.$commentss->id.'"><i class="fe fe-trash" data-id="'.$commentss->id.'"></i>'.csrf_field().'</a></li>
                                                        </ul>
                                                    </div>
                                                    <span class="file-name-1">
                                                        '.Str::limit($commentss->file_name, 10, $end='.......').'
                                                    </span>
                                                </div>
                                                ';
                                            }
                                        $output .= '</div>';
                                    }else{
                                        $output .= '<div class="row galleryopen">';
                                            foreach ($comment->getMedia('comments') as $commentss){
                                                $output .= '<div class="file-image-1  removespruko'.$commentss->id.'" id="imageremove'.$commentss->id.'">
                                                    <div class="product-image">
                                                        <a href="'.$commentss->getFullUrl().'" class="imageopen">
                                                            <img src="'.$commentss->getFullUrl().'" class="br-5" alt="'.$commentss->file_name.'">
                                                        </a>
                                                    </div>
                                                    <span class="file-name-1">
                                                        '.Str::limit($commentss->file_name, 10, $end='.......').'
                                                    </span>
                                                </div>
                                                ';
                                            }
                                        $output .= '</div>';
                                    }
                                $output .= '</div>';
                                
                                    if (Auth::id() == $comment->user_id){
                                        if($comment->display != null)
                                        $output .= '<div class="ms-auto">
                                        <span class="action-btns supportnote-icon" onclick="showEditForm('.$comment->id.')"><i class="feather feather-edit text-primary fs-16"></i></span>
                                    </div>';
                                    }
                                
                    
                            $output .= '</div>
                        </div>';
                    }else{

                        $output .= '<div class="card-body">
                            <div class="d-sm-flex">
                                <div class="d-flex me-3">
                                    <a href="#">';
                                        if($comment->user != null){
                                            if ($comment->user->image == null){
                                                $output .= '<img src="'.asset('uploads/profile/user-profile.png').'"  class="media-object brround avatar-lg" alt="default">';
                                            }else{
                                                $output .= '<img class="media-object brround avatar-lg" alt="'.$comment->user->image.'" src="'.asset('uploads/profile/'. $ticket->user->image).'">';
                                            }
                                        }else{
                                            $output .= '<img src="'.asset('uploads/profile/user-profile.png').'"  class="media-object brround avatar-lg" alt="default">';
                                        }
                                    $output .= '</a>
                                </div>
                                <div class="media-body">';
                                    if($comment->user != null){
                                        $output .= '<h5 class="mt-1 mb-1 font-weight-semibold">'.$comment->user->name.'<span class="badge badge-primary-light badge-md ms-2">'.$comment->user->getRoleNames()[0].'</span></h5>';
                                    }else{
                                        $output .= '<h5 class="mt-1 mb-1 font-weight-semibold text-muted">~</h5>';
                                    }
                                    $output .= '<small class="text-muted"><i class="feather feather-clock"></i>'.$comment->created_at->diffForHumans().'</small>
                                    <span class="fs-13 mb-0 mt-1" value="">
                                        '.$comment->comment.'
                                    </span>
                                    <div class="row galleryopen">';
                                        foreach ($comment->getMedia('comments') as $commentss){
                                            $output .= '<div class="file-image-1  removespruko'.$commentss->id.'" id="imageremove{{$commentss->id}}">
                                                <div class="product-image  ">
                                                    <a href="'.$commentss->getFullUrl().'" class="imageopen">
                                                        <img src="'.$commentss->getFullUrl().'" class="br-5" alt="'.$commentss->file_name.'">
                                                    </a>
                                                </div>
                                                <span class="file-name-1">
                                                    '.Str::limit($commentss->file_name, 10, $end='.......').'
                                                </span>
                                            </div>';
                                        }
                                    $output .= '</div>
                                </div>
                            </div>
                        </div>';

                    }
                }else{
                    $output .= '<div class="card-body">
                        <div class="d-sm-flex">
                            <div class="d-flex me-3">
                                <a href="#">';
                                    if ($comment->cust->image == null){
                                        $output .= ' <img src="'.asset('uploads/profile/user-profile.png').'"  class="media-object brround avatar-lg" alt="default">';
                                    }else{
                                        $output .= '<img class="media-object brround avatar-lg" alt="'.$comment->cust->image.'" src="'.asset('uploads/profile/'. $ticket->cust->image).'">';
                                    }
                                $output .= ' </a>
                            </div>
                            <div class="media-body">
                                <h5 class="mt-1 mb-1 font-weight-semibold">'.$comment->cust->username.'<span class="badge badge-primary-light badge-md ms-2">'.$comment->cust->userType.'</span></h5>
                                <small class="text-muted"><i class="feather feather-clock"></i>'.$comment->created_at->diffForHumans().'</small>
                                <span class="fs-13 mb-0 mt-1" value="">
                                    '.$comment->comment.'
                                </span>
                                <div class="row galleryopen">';
                                    foreach ($comment->getMedia('comments') as $commentss){
                                        $output .= '<div class="file-image-1  removespruko'.$commentss->id.'" id="imageremove'.$commentss->id.'">
                                            <div class="product-image">
                                                <a href="'.$commentss->getFullUrl().'" class="imageopen">
                                                    <img src="'.$commentss->getFullUrl().'" class="br-5" alt="'.$commentss->file_name.'">
                                                </a>
                                            </div>
                                            <span class="file-name-1">
                                                '.Str::limit($commentss->file_name, 10, $end='.......').'
                                            </span>
                                        </div>';
                                    }
                                $output .= '</div>
                            </div>
                        </div>
                    </div>';
                }
                $last_id = $comment->id;
                $i++;
            }

            $output .= '
       <div id="load_more">
        <button type="button" name="load_more_button" class="btn btn-success" data-id="'.$last_id.'" id="load_more_button">Load More</button>
       </div>
       ';
            }
            else
                {
                $output .= '
                <div id="load_more">
                    <button type="button" name="load_more_button" class="btn btn-info ">No Data Found</button>
                </div>
                ';
                }

            return response()->json(['html' => $output, 'coment' => $comments]);
        }
    }


    /**
     * Close the specified ticket.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function close(Request $request,$ticket_id, AppMailer $mailer)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status = $request->input('status');

        $ticket->update();

        $ticketOwner = $ticket->user;

        $mailer->sendTicketStatusNotification($ticketOwner, $ticket);

        return redirect()->back()->with("warning", "The ticket has been closed.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('Ticket Delete');
        $ticket = Ticket::findOrFail($id);
        $comment = $ticket->comments()->get();


        if (count($comment) > 0) {
            $media = $ticket->getMedia('ticket');

            foreach ($media as $media) {
              
                    $media->delete();
                
            }
            $medias = $ticket->comments()->get();
            
            foreach ($medias as $mediass) {
                foreach($mediass->getMedia('comments') as $mediasss){

                    $mediasss->delete();
                }
            
            }
            $comment->each->delete();
            $ticket->delete();
            return response()->json(['error'=>'Ticket is Deleted Successfully']);
        }else{
           
            $media = $ticket->getMedia('ticket');

            foreach ($media as $media) {
              
                    $media->delete();
                
            }
            $ticket->delete();

            return response()->json(['error'=> trans('langconvert.functions.ticketdelete')]);

        }
    }


    public function ticketmassdestroy(Request $request){
        $student_id_array = $request->input('id');

        $tickets = Ticket::whereIn('id', $student_id_array)->get();

        foreach($tickets as $ticket){
            $comment = $ticket->comments()->get();


            if (count($comment) > 0) {
                $media = $ticket->getMedia('ticket');

                foreach ($media as $media) {
                
                        $media->delete();
                    
                }
                $medias = $ticket->comments()->get();
            
                foreach ($medias as $mediass) {
                    foreach($mediass->getMedia('comments') as $mediasss){
    
                        $mediasss->delete();
                    }
                
                }
                $comment->each->delete();
                $tickets->each->delete();
                return response()->json(['error'=> trans('langconvert.functions.ticketdelete')]);
            }else{
            
                $media = $ticket->getMedia('ticket');

                foreach ($media as $media) {
                
                        $media->delete();
                    
                }
                $tickets->each->delete();
            }
        }
        return response()->json(['error'=> trans('langconvert.functions.ticketdelete')]);
        
    }

    // Admin Ticket View
    public function createticket()
    {

        $this->authorize('Ticket Create');
            $title = Apptitle::first();
            $data['title'] = $title;

            $footertext = Footertext::first();
            $data['footertext'] = $footertext;

            $seopage = Seosetting::first();
            $data['seopage'] = $seopage;

            $post = Pages::all();
            $data['page'] = $post;

            $categories = Category::whereIn('display',['ticket', 'both'])->where('status', '1')->get();
            $data['categories'] = $categories;

        return view('admin.viewticket.createticket')->with($data);
    }

    // Admins Creating  Ticket
    public function gueststore(Request $request)
    {
        $this->authorize('Ticket Create');

        $this->validate($request, [
            'subject' => 'required|string|max:255',
            'category' => 'required',
            'message' => 'required',
            'email' => 'required|max:255',
        ]);
        $userexits = Customer::where('email', $request->email)->count();
        if($userexits == 1){
            $guest = Customer::where('email', $request->email)->first();
           
        }else{
            $guest = Customer::create([

                'firstname' => '',
                'lastname' => '',
                'username' => 'GUEST',
                'email' => $request->email,
                'userType' => 'Guest',
                'password' => null,
                'country' => '',
                'timezone' => 'UTC',
                'status' => '1',
                'image' => null,

            ]);
            $customersetting = new CustomerSetting();
            $customersetting->custs_id = $guest->id;
            $customersetting->save();
        }
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
        $ticket->user_id = Auth::user()->id;
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

        foreach ($request->input('ticket', []) as $file) {
            $ticket->addMedia(public_path('uploads/guestticket/' . $file))->toMediaCollection('ticket');
        }

        // create ticket notification
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
        $cust = Customer::with('custsetting')->find($ticket->cust_id);
        $cust->notify(new TicketCreateNotifications($ticket));

        $ticketData = [
            'ticket_username' => $ticket->cust->username,
            'ticket_id' => $ticket->ticket_id,
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
            return response()->json(['success' => trans('langconvert.functions.ticketcreate') . $ticket->ticket_id], 200);
        }

        return response()->json(['success' => trans('langconvert.functions.ticketcreate') . $ticket->ticket_id], 200);
    
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

    public function mytickets()
    {
        $this->authorize('My Tickets');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $agent = User::count();
        $data['agent'] = $agent;

        $customer = Customer::count();
        $data['customer'] = $customer;



        
        if(request()->ajax()) {
            $data = Ticket::where('user_id', auth()->id())->latest('updated_at')->get();
    
            return DataTables::of($data)
        
            ->addColumn('ticket_id', function($data){
                $note = DB::table('ticketnotes')->pluck('ticketnotes.ticket_id')->toArray();
                if($data->ticketnote->isEmpty()){
                    $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span>';
                }else{
                $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span> <span class="badge badge-warning-light">Note</span>';
                }
                return $ticket_id;
            })
            ->addColumn('subject', function($data){
                
                $subject = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.Str::limit($data->subject, '40').'</a>';
            
                return $subject;
            })
            ->addColumn('cust_id',function($data){
                $cust_id = $data->cust->username;
                return $cust_id;
            })
            ->addColumn('priority',function($data){
                if($data->priority != null){
                    if($data->priority == "Low"){
                        $priority = '<span class="badge badge-success-light">'.$data->priority.'</span>';
                    }
                    elseif($data->priority == "High"){
                        $priority = '<span class="badge badge-danger-light">'.$data->priority.'</span>';
                    }
                    elseif($data->priority == "Critical"){
                        $priority = '<span class="badge badge-danger-dark">'.$data->priority.'</span>';
                    }
                    else{
                        $priority = '<span class="badge badge-warning-light">'.$data->priority.'</span>';
                    }
                }else{
                    $priority = '~';
                }
                return $priority;
            })
            ->addColumn('created_at',function($data){
                $created_at = $data->created_at->format(setting('date_format'));
                return $created_at;
            })
            ->addColumn('category_id', function($data){
                if($data->category_id != null){
                    $category_id = Str::limit($data->category->name, '40');
                    return $category_id;
                }else{
                    return '~';
                }
            })
            ->addColumn('status', function($data){
    
                if($data->purchasecodesupport != null){

                    if($data->purchasecodesupport == 'Supported'){
                        if($data->status == "New"){
                            $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span> <span class="badge badge badge-success"> Supported </span>';
        
                        }
                        elseif($data->status == "Re-Open"){
                            $status = '<span class="badge badge-teal">'.$data->status.'</span> <span class="badge badge badge-success"> Supported </span>';
                        }
                        elseif($data->status == "Inprogress"){
                            $status = '<span class="badge badge-info">'.$data->status.'</span> <span class="badge badge badge-success"> Supported </span>';
                        }
                        elseif($data->status == "On-Hold"){
                            $status = '<span class="badge badge-warning">'.$data->status.'</span> <span class="badge badge badge-success"> Supported </span>';
                        }
                        else{
                            $status = '<span class="badge badge-danger">'.$data->status.'</span> <span class="badge badge badge-success"> Supported </span>';
                        }
        
                        return $status;
                    }
                    if($data->purchasecodesupport == 'Expired'){
                        if($data->status == "New"){
                            $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span> <span class="badge badge-danger-dark"> Support Expired </span>';
        
                        }
                        elseif($data->status == "Re-Open"){
                            $status = '<span class="badge badge-teal">'.$data->status.'</span> <span class="badge badge-danger-dark"> Support Expired </span>';
                        }
                        elseif($data->status == "Inprogress"){
                            $status = '<span class="badge badge-info">'.$data->status.'</span> <span class="badge badge-danger-dark"> Support Expired </span>';
                        }
                        elseif($data->status == "On-Hold"){
                            $status = '<span class="badge badge-warning">'.$data->status.'</span> <span class="badge badge-danger-dark"> Support Expired </span>';
                        }
                        else{
                            $status = '<span class="badge badge-danger">'.$data->status.'</span> <span class="badge badge-danger-dark"> Support Expired </span>';
                        }
        
                        return $status;
                    }

                }
                if($data->purchasecodesupport == null){

                    if($data->status == "New"){
                        $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span>';
    
                    }
                    elseif($data->status == "Re-Open"){
                        $status = '<span class="badge badge-teal">'.$data->status.'</span> ';
                    }
                    elseif($data->status == "Inprogress"){
                        $status = '<span class="badge badge-info">'.$data->status.'</span>';
                    }
                    elseif($data->status == "On-Hold"){
                        $status = '<span class="badge badge-warning">'.$data->status.'</span>';
                    }
                    else{
                        $status = '<span class="badge badge-danger">'.$data->status.'</span>';
                    }
    
                    return $status;

                }
            })
            ->addColumn('toassignuser_id', function($data){
                if(Auth::user()->can('Ticket Assign')){
                    if($data->toassignuser == null){
                        $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                        Assign
                        </a>';
                    }
                    else{
                        if($data->toassignuser_id != null){
                            $toassignuser_id = '
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
                            
                            <a href="javascript:void(0)" data-id="' .$data->id.'"  class="btn btn-outline-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">'.$data->toassignuser->name.'</a>
                            
                            <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove"><i class="fe fe-x" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"></i></a>
                            </div>
                            ';
            
                        }else{
                            $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                        Assign
                        </a>';
                        }
                    }
                }
                else{
                    $toassignuser_id = '~';
                }
                return $toassignuser_id;
            })
            ->addColumn('last_reply', function($data){
                if($data->last_reply == null){
                    $last_reply = $data->created_at->diffForHumans();
                }else{
                    $last_reply = $data->last_reply->diffForHumans();
                }
    
                return $last_reply;
            })
            ->addColumn('action', function($data){
    
                $button = '<div class = "d-flex">';
                if(Auth::user()->can('Ticket Edit')){
    
                    $button .= '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
                }else{
                    $button .= '~';
                }
                if(Auth::user()->can('Ticket Delete')){
                    $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="show-delete" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                }else{
                    $button .= '~';
                }
                
                $button .= '</div>';
                return $button;
            })
            ->addColumn('checkbox', function($data){
                if(Auth::user()->can('Ticket Delete')){
                    return '<input type="checkbox" name="student_checkbox[]" class="checkall" value="'.$data->id.'" />';
                }else{
                    return '<input type="checkbox" name="student_checkbox[]" class="checkall" value="'.$data->id.'" disabled />';
                }
            })
            ->rawColumns(['action','cust_id','subject','status','priority','created_at','toassignuser_id','last_reply','ticket_id','checkbox'])
            ->addIndexColumn()
            ->make(true);
                
        }
       
        
       return view('admin.viewticket.myticket')->with($data);
 
        
    }


    public function note(Request $request){

        $ticketnote = Ticketnote::create([
            'ticket_id' => $request->input('ticket_id'),
            'user_id' => Auth::user()->id,
            'ticketnotes' => $request->input('ticketnote')
        ]);

        return response()->json(['success'=> trans('langconvert.functions.ticketnote')]);
    }

    public function noteshow($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        $comments = $ticket->comments;
        $category = $ticket->category;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;


        return view('admin.viewticket.note', compact('ticket','category', 'comments', 'title','footertext'))->with($data);
    }

    public function notedestroy($id)
    {
        $ticketnotedelete = Ticketnote::find($id);
        $ticketnotedelete->delete();

        return response()->json(['error'=> trans('langconvert.functions.ticketnotedelete')]);


    }

    public function sublist(Request $request){

        $parent_id = $request->cat_id;
            
        $subcategories =Projects::select('projects.*','projects_categories.category_id')->join('projects_categories','projects_categories.projects_id', 'projects.id')
        ->where('projects_categories.category_id',$parent_id)
        ->get();

        return response()->json([
            'subcategories' => $subcategories
        ]);

    }


    public function changepriority(Request $req){

        $this->validate($req, [
            'priority_user_id' => 'required',
        ]);

        $priority = Ticket::find($req->priority_id);
        $priority->priority = $req->priority_user_id;
        $priority->update();

        $priorityname = $priority->priority;
        return response()->json(['priority' => $priorityname,'success' => trans('langconvert.functions.updatecommon')], 200);
    }

    public function alltickets(){

        $this->authorize('My Tickets');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $agent = User::count();
        $data['agent'] = $agent;

        $customer = Customer::count();
        $data['customer'] = $customer;

        $groupexists = Groupsusers::where('users_id', Auth::id())->exists();

        // if there in group get group tickets
        if($groupexists){

            if(request()->ajax()) {
                $data = Ticket::select('tickets.*',"groups_categories.group_id","groups_users.users_id")
                ->leftJoin('groups_categories','groups_categories.category_id','tickets.category_id')
                ->leftJoin('groups_users','groups_users.groups_id','groups_categories.group_id')
                ->whereNotNull('groups_users.users_id')
                ->where('groups_users.users_id', Auth::id())
                ->latest('tickets.updated_at')
                ->get();
                    
                return DataTables::of($data)
                ->addColumn('ticket_id', function($data){
                    $note = DB::table('ticketnotes')->pluck('ticketnotes.ticket_id')->toArray();
                    if($data->ticketnote->isEmpty()){
                        $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span>';
                    }else{
                    $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span> <span class="badge badge-warning-light">Note</span>';
                    }
                    return $ticket_id;
                })
                ->addColumn('subject', function($data){

                    $subject = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.Str::limit($data->subject, '40').'</a>';
                    
                    return $subject;
                })
                ->addColumn('cust_id',function($data){
                    $cust_id = $data->cust->username;
                    return $cust_id;
                })
                ->addColumn('priority',function($data){
                    if($data->priority != null){
                        if($data->priority == "Low"){
                            $priority = '<span class="badge badge-success-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "High"){
                            $priority = '<span class="badge badge-danger-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "Critical"){
                            $priority = '<span class="badge badge-danger-dark">'.$data->priority.'</span>';
                        }
                        else{
                            $priority = '<span class="badge badge-warning-light">'.$data->priority.'</span>';
                        }
                    }else{
                        $priority = '~';
                    }
                    return $priority;
                })
                ->addColumn('created_at',function($data){
                    $created_at = $data->created_at->format(setting('date_format'));
                    return $created_at;
                })
                ->addColumn('category_id', function($data){
                    if($data->category_id != null){
                        $category_id = Str::limit($data->category->name, '40');
                        return $category_id;
                    }else{
                        return '~';
                    }
                    
                })
                ->addColumn('status', function($data){
    
                    if($data->purchasecodesupport != null){

                        if($data->purchasecodesupport == 'Supported'){
                            if($data->status == "New"){
                                $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span> <span class="badge badge badge-success"> Supported </span>';
            
                            }
                            elseif($data->status == "Re-Open"){
                                $status = '<span class="badge badge-teal">'.$data->status.'</span> <span class="badge badge badge-success"> Supported </span>';
                            }
                            elseif($data->status == "Inprogress"){
                                $status = '<span class="badge badge-info">'.$data->status.'</span> <span class="badge badge badge-success"> Supported </span>';
                            }
                            elseif($data->status == "On-Hold"){
                                $status = '<span class="badge badge-warning">'.$data->status.'</span> <span class="badge badge badge-success"> Supported </span>';
                            }
                            else{
                                $status = '<span class="badge badge-danger">'.$data->status.'</span> <span class="badge badge badge-success"> Supported </span>';
                            }
            
                            return $status;
                        }
                        if($data->purchasecodesupport == 'Expired'){
                            if($data->status == "New"){
                                $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span> <span class="badge badge-danger-dark"> Support Expired </span>';
            
                            }
                            elseif($data->status == "Re-Open"){
                                $status = '<span class="badge badge-teal">'.$data->status.'</span> <span class="badge badge-danger-dark"> Support Expired </span>';
                            }
                            elseif($data->status == "Inprogress"){
                                $status = '<span class="badge badge-info">'.$data->status.'</span> <span class="badge badge-danger-dark"> Support Expired </span>';
                            }
                            elseif($data->status == "On-Hold"){
                                $status = '<span class="badge badge-warning">'.$data->status.'</span> <span class="badge badge-danger-dark"> Support Expired </span>';
                            }
                            else{
                                $status = '<span class="badge badge-danger">'.$data->status.'</span> <span class="badge badge-danger-dark"> Support Expired </span>';
                            }
            
                            return $status;
                        }

                    }
                    if($data->purchasecodesupport == null){

                        if($data->status == "New"){
                            $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span>';
        
                        }
                        elseif($data->status == "Re-Open"){
                            $status = '<span class="badge badge-teal">'.$data->status.'</span> ';
                        }
                        elseif($data->status == "Inprogress"){
                            $status = '<span class="badge badge-info">'.$data->status.'</span>';
                        }
                        elseif($data->status == "On-Hold"){
                            $status = '<span class="badge badge-warning">'.$data->status.'</span>';
                        }
                        else{
                            $status = '<span class="badge badge-danger">'.$data->status.'</span>';
                        }
        
                        return $status;

                    }
                })
                ->addColumn('last_reply', function($data){
                    if($data->last_reply == null){
                        $last_reply = $data->created_at->diffForHumans();
                    }else{
                        $last_reply = $data->last_reply->diffForHumans();
                    }
    
                    return $last_reply;
                })
                ->addColumn('action', function($data){
    
                    $button = '<div class = "d-flex">';
                    if(Auth::user()->can('Ticket Edit')){
    
                        $button .= '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
                    }else{
                    $button .= '~';
                    }
                    if(Auth::user()->can('Ticket Delete')){
                        $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="show-delete" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                    }else{
                    $button .= '~';
                    }
                    
                    $button .= '</div>';
                    return $button;
                })
                ->addColumn('toassignuser_id', function($data){
                    if(Auth::user()->can('Ticket Assign')){
                        if($data->toassignuser == null){
                            $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                        }
                        else{
                            if($data->toassignuser_id != null){
                                $toassignuser_id = '
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'"  class="btn btn-outline-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">'.$data->toassignuser->name.'</a>
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove"><i class="fe fe-x" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"></i></a>
                                </div>
                                ';
                
                            }else{
                                $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm"data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                            }
                        }
                    }
                    else{
                        $toassignuser_id = '~';
                    }
                    return $toassignuser_id;
                })
                ->addColumn('checkbox', function($data){
                    if(Auth::user()->can('Ticket Delete')){
                        return '<input type="checkbox" name="student_checkbox[]" class="checkall" value="'.$data->id.'" />';
                    }else{
                        return '<input type="checkbox" name="student_checkbox[]" class="checkall" value="'.$data->id.'" disabled />';
                    }
                })
                ->rawColumns(['action','cust_id','status','priority','created_at','last_reply','ticket_id','subject','checkbox','toassignuser_id'])
                ->addIndexColumn()
                ->make(true);
            }
        }
        // If no there in group we get the all tickets
        else{
            

            if(request()->ajax()) {
                $data = Ticket::latest('updated_at')->get();
        
                return DataTables::of($data)
            
                ->addColumn('ticket_id', function($data){
                    $note = DB::table('ticketnotes')->pluck('ticketnotes.ticket_id')->toArray();
                    if($data->ticketnote->isEmpty()){
                        $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span>';
                    }else{
                    $ticket_id = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.$data->ticket_id.'</a> <span class="badge badge-danger-light">'.$data->overduestatus.'</span> <span class="badge badge-warning-light">Note</span>';
                    }
                    return $ticket_id;
                })
                ->addColumn('subject', function($data){
                   
                    $subject = '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'">'.Str::limit($data->subject, '40').'</a>';
                    
                    return $subject;
                })
                ->addColumn('cust_id',function($data){
                    $cust_id = $data->cust->username;
                    return $cust_id;
                })
                ->addColumn('priority',function($data){
                    if($data->priority != null){
                        if($data->priority == "Low"){
                            $priority = '<span class="badge badge-success-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "High"){
                            $priority = '<span class="badge badge-danger-light">'.$data->priority.'</span>';
                        }
                        elseif($data->priority == "Critical"){
                            $priority = '<span class="badge badge-danger-dark">'.$data->priority.'</span>';
                        }
                        else{
                            $priority = '<span class="badge badge-warning-light">'.$data->priority.'</span>';
                        }
                    }else{
                        $priority = '~';
                    }
                    return $priority;
                })
                ->addColumn('created_at',function($data){
                    $created_at = $data->created_at->format(setting('date_format'));
                    return $created_at;
                })
                ->addColumn('category_id', function($data){
                    if($data->category_id != null){
                        $category_id = Str::limit($data->category->name, '40');
                        return $category_id;
                    }else{
                        return '~';
                    }
                })
                ->addColumn('status', function($data){
        
                    if($data->purchasecodesupport != null){

                        if($data->purchasecodesupport == 'Supported'){
                            if($data->status == "New"){
                                $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span> <span class="badge badge badge-success"> Supported </span>';
            
                            }
                            elseif($data->status == "Re-Open"){
                                $status = '<span class="badge badge-teal">'.$data->status.'</span> <span class="badge badge badge-success"> Supported </span>';
                            }
                            elseif($data->status == "Inprogress"){
                                $status = '<span class="badge badge-info">'.$data->status.'</span> <span class="badge badge badge-success"> Supported </span>';
                            }
                            elseif($data->status == "On-Hold"){
                                $status = '<span class="badge badge-warning">'.$data->status.'</span> <span class="badge badge badge-success"> Supported </span>';
                            }
                            else{
                                $status = '<span class="badge badge-danger">'.$data->status.'</span> <span class="badge badge badge-success"> Supported </span>';
                            }
            
                            return $status;
                        }
                        if($data->purchasecodesupport == 'Expired'){
                            if($data->status == "New"){
                                $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span> <span class="badge badge-danger-dark"> Support Expired </span>';
            
                            }
                            elseif($data->status == "Re-Open"){
                                $status = '<span class="badge badge-teal">'.$data->status.'</span> <span class="badge badge-danger-dark"> Support Expired </span>';
                            }
                            elseif($data->status == "Inprogress"){
                                $status = '<span class="badge badge-info">'.$data->status.'</span> <span class="badge badge-danger-dark"> Support Expired </span>';
                            }
                            elseif($data->status == "On-Hold"){
                                $status = '<span class="badge badge-warning">'.$data->status.'</span> <span class="badge badge-danger-dark"> Support Expired </span>';
                            }
                            else{
                                $status = '<span class="badge badge-danger">'.$data->status.'</span> <span class="badge badge-danger-dark"> Support Expired </span>';
                            }
            
                            return $status;
                        }

                    }
                    if($data->purchasecodesupport == null){

                        if($data->status == "New"){
                            $status = '<span class="badge badge-burnt-orange"> '.$data->status.' </span>';
        
                        }
                        elseif($data->status == "Re-Open"){
                            $status = '<span class="badge badge-teal">'.$data->status.'</span> ';
                        }
                        elseif($data->status == "Inprogress"){
                            $status = '<span class="badge badge-info">'.$data->status.'</span>';
                        }
                        elseif($data->status == "On-Hold"){
                            $status = '<span class="badge badge-warning">'.$data->status.'</span>';
                        }
                        else{
                            $status = '<span class="badge badge-danger">'.$data->status.'</span>';
                        }
        
                        return $status;

                    }
                })
                ->addColumn('toassignuser_id', function($data){
                    if(Auth::user()->can('Ticket Assign')){
                        if($data->toassignuser == null){
                            $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                        }
                        else{
                            if($data->toassignuser_id != null){
                                $toassignuser_id = '
                                <div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'"  class="btn btn-outline-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">'.$data->toassignuser->name.'</a>
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove"><i class="fe fe-x" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"></i></a>
                                </div>
                                ';
                
                            }else{
                                $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                            Assign
                            </a>';
                            }
                        }
                    }
                    else{
                        $toassignuser_id = '~';
                    }
                    return $toassignuser_id;
                })
                ->addColumn('last_reply', function($data){
                    if($data->last_reply == null){
                        $last_reply = $data->created_at->diffForHumans();
                    }else{
                        $last_reply = $data->last_reply->diffForHumans();
                    }
        
                    return $last_reply;
                })
                ->addColumn('action', function($data){
        
                    $button = '<div class = "d-flex">';
                    if(Auth::user()->can('Ticket Edit')){
        
                        $button .= '<a href="'.url('admin/ticket-view/' . $data->ticket_id).'" class="action-btns1 edit-testimonial"><i class="feather feather-edit text-primary" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"></i></a>';
                    }else{
                        $button .= '~';
                    }
                    if(Auth::user()->can('Ticket Delete')){
                        $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" id="show-delete" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'"data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                    }else{
                        $button .= '~';
                    }
                    
                    $button .= '</div>';
                    return $button;
                })
                ->addColumn('checkbox', function($data){
                    if(Auth::user()->can('Ticket Delete')){
                        return '<input type="checkbox" name="student_checkbox[]" class="checkall" value="'.$data->id.'" />';
                    }else{
                        return '<input type="checkbox" name="student_checkbox[]" class="checkall" value="'.$data->id.'" disabled />';
                    }
                })
                ->rawColumns(['action','cust_id','subject','status','priority','created_at','toassignuser_id','last_reply','ticket_id','checkbox'])
                ->addIndexColumn()
                ->make(true);
                 
            }
        }

        return view('admin.viewticket.alltickets')->with($data);
    }
}
