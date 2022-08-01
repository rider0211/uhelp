<?php

namespace App\Http\Controllers\User\Ticket;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Ticket\Ticket;
use App\Models\Ticket\Comment;
use App\Models\Ticket\Category;
use App\Mail\AppMailer;
use App\Models\User;
use App\Models\Role;
use App\Models\Apptitle;
use DB;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\Projects;
use URL;
use Mail;
use App\Mail\mailmailablesend;
use App\Notifications\TicketCreateNotifications;
use App\Models\Customer;
use App\Models\Groupsusers;
use DataTables;
use Str;
use App\Models\Articles\Article;

class TicketController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
        
        $categories = Category::whereIn('display',['ticket', 'both'])->where('status', '1')
            ->get();

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $populararticle = Article::orderBy('views','desc')->latest()->paginate(5);
        $data['populararticles'] = $populararticle;

        $projects = Projects::select('projects.*','projects_categories.category_id')->join('projects_categories','projects_categories.projects_id', 'projects.id')->get();
        $data['projects'] = $projects;

        return view('user.ticket.create', compact('categories','title','footertext'))->with($data);
        
  
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'subject' => 'required|max:255',
            'category' => 'required',
            'message' => 'required',
            
        ]);

        $ticket = Ticket::create([
            'subject' => $request->input('subject'),
            'cust_id' => Auth::guard('customer')->user()->id,
            'category_id' => $request->input('category'),
            'message' => $request->input('message'),
            'project' => $request->input('project'),
            'status' => 'New',
        ]);
        $ticket = Ticket::find($ticket->id);
        $ticket->ticket_id = setting('CUSTOMER_TICKETID').'-'.$ticket->id;
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
        $ticket->addMedia(public_path('uploads/ticket/' . $file))->toMediaCollection('ticket');
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
        
        
        $ticketData = [
            'ticket_username' => $ticket->cust->username,
            'ticket_id' => $ticket->ticket_id,
            'ticket_title' => $ticket->subject,
            'ticket_description' => $ticket->message,
            'ticket_customer_url' => route('loadmore.load_data', $ticket->ticket_id),
            'ticket_admin_url' => url('/admin/ticket-view/'.$ticket->ticket_id),
        ];

        try{

            Mail::to($ticket->cust->email)
            ->send( new mailmailablesend( 'customer_send_ticket_created', $ticketData ) );

            Mail::to(setting('mail_from_address'))
            ->send( new mailmailablesend( 'admin_send_email_ticket_created', $ticketData ) );
        
        }catch(\Exception $e){
            return response()->json(['success' => trans('langconvert.functions.ticketcreate') . $ticket->ticket_id], 200);
        }

        return response()->json(['success' => trans('langconvert.functions.ticketcreate') . $ticket->ticket_id], 200);
        
    }

    public function storeMedia(Request $request)
    {
        $path = public_path('uploads/ticket');
    
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

    public function activeticket(){

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if(request()->ajax()) {
            $data = Ticket::where('cust_id', Auth::guard('customer')->user()->id)->whereIn('status', ['New', 'Re-Open','Inprogress'])->latest('updated_at')->get();
    
            return DataTables::of($data)
        
            ->addColumn('ticket_id', function($data){
                
                return '<a href="'.route('loadmore.load_data',$data->ticket_id).'">'.$data->ticket_id.'</a>';
            })
            ->addColumn('subject', function($data){
                $subject = '<a href="'.route('loadmore.load_data',$data->ticket_id).'">'.Str::limit($data->subject, '10').'</a>';
                return $subject;
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
                    $category_id = Str::limit($data->category->name, '10');
                    return $category_id;
                }else{
                    return '~';
                }
            })
            ->addColumn('status', function($data){
    
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
                $button .= '<a href="'.route('loadmore.load_data',$data->ticket_id).'" class="action-btns1" data-bs-toggle="tooltip" data-placement="top" title="View Ticket"><i class="feather feather-edit text-primary"></i></a>
                            <a href="javascript:void(0)" class="action-btns1" data-id="'.$data->id.'" id="show-delete" data-bs-toggle="tooltip" data-placement="top" title="Delete Ticket"><i class="feather feather-trash-2 text-danger"></i></a>';
                $button .= '</div>';
              return $button;
            })
            ->addColumn('checkbox', '<input type="checkbox" name="student_checkbox[]" class="checkall" value="{{$id}}" />')
              ->rawColumns(['action','subject','status','priority','created_at','last_reply','ticket_id','checkbox'])
              ->addIndexColumn()
              ->make(true);
             
        }
        
        return view('user.ticket.viewticket.activeticket', compact('title','footertext'))->with($data);
    } 
    
    public function closedticket(){

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if(request()->ajax()) {
            $data = Ticket::where('cust_id', Auth::guard('customer')->user()->id)->where('status', 'Closed')->latest('updated_at')->get();
    
            return DataTables::of($data)
        
            ->addColumn('ticket_id', function($data){
                
                return '<a href="'.route('loadmore.load_data',$data->ticket_id).'">'.$data->ticket_id.'</a>';
            })
            ->addColumn('subject', function($data){
                $subject = '<a href="'.route('loadmore.load_data',$data->ticket_id).'">'.Str::limit($data->subject, '10').'</a>';
                return $subject;
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
                    $category_id = Str::limit($data->category->name, '10');
                    return $category_id;
                }else{
                    return '~';
                }
            })
            ->addColumn('status', function($data){
    
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
                $button .= '<a href="'.route('loadmore.load_data',$data->ticket_id).'" class="action-btns1" data-bs-toggle="tooltip" data-placement="top" title="View Ticket"><i class="feather feather-edit text-primary"></i></a>
                            <a href="javascript:void(0)" class="action-btns1" data-id="'.$data->id.'" id="show-delete" data-bs-toggle="tooltip" data-placement="top" title="Delete Ticket"><i class="feather feather-trash-2 text-danger"></i></a>';
                $button .= '</div>';
              return $button;
            })
            ->addColumn('checkbox', '<input type="checkbox" name="student_checkbox[]" class="checkall" value="{{$id}}" />')
              ->rawColumns(['action','subject','status','priority','created_at','last_reply','ticket_id','checkbox'])
              ->addIndexColumn()
              ->make(true);
             
        }
        
        return view('user.ticket.viewticket.closedticket', compact( 'title','footertext'))->with($data);
    }  

    public function onholdticket(){

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if(request()->ajax()) {
            $data = Ticket::where('cust_id', Auth::guard('customer')->user()->id)->where('status', 'On-Hold')->latest('updated_at')->get();
    
            return DataTables::of($data)
        
            ->addColumn('ticket_id', function($data){
                
                return '<a href="'.route('loadmore.load_data',$data->ticket_id).'">'.$data->ticket_id.'</a>';
            })
            ->addColumn('subject', function($data){
                $subject = '<a href="'.route('loadmore.load_data',$data->ticket_id).'">'.Str::limit($data->subject, '10').'</a>';
                return $subject;
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
                    $category_id = Str::limit($data->category->name, '10');
                    return $category_id;
                }else{
                    return '~';
                }
            })
            ->addColumn('status', function($data){
    
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
                $button .= '<a href="'.route('loadmore.load_data',$data->ticket_id).'" class="action-btns1" data-bs-toggle="tooltip" data-placement="top" title="View Ticket"><i class="feather feather-edit text-primary"></i></a>
                            <a href="javascript:void(0)" class="action-btns1" data-id="'.$data->id.'" id="show-delete" data-bs-toggle="tooltip" data-placement="top" title="Delete Ticket"><i class="feather feather-trash-2 text-danger"></i></a>';
                $button .= '</div>';
              return $button;
            })
            ->addColumn('checkbox', '<input type="checkbox" name="student_checkbox[]" class="checkall" value="{{$id}}" />')
              ->rawColumns(['action','subject','status','priority','created_at','last_reply','ticket_id','checkbox'])
              ->addIndexColumn()
              ->make(true);
             
        }
        
        return view('user.ticket.viewticket.onholdticket', compact( 'title','footertext'))->with($data);
    }
      

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $req, $ticket_id)
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

        if (request()->ajax()) {
            $view = view('user.ticket.showticketdata',compact('comments'))->render();
            return response()->json(['html'=>$view]);
        }
        return view('user.ticket.showticket', compact('ticket','category', 'comments', 'title','footertext'))->with($data);
        
       
    }



    /**
     * Close the specified ticket.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
            'ticket_username' => $ticket->cust->username,
            'ticket_id' => $ticket->ticket_id,
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $ticket = Ticket::findOrFail($id);
        $comment = $ticket->comments()->get();


        if (count($comment) > 0) {
            $media = $ticket->getMedia('ticket');

            foreach ($media as $media) {
              
                    $media->delete();
                
            }
            $medias = $ticket->comments()->firstOrFail()->getMedia('comments');

            foreach ($medias as $mediass) {
                
                $mediass->delete();
            
            }
            $comment->each->delete();
            $ticket->delete();
            return response()->json(['error'=>trans('langconvert.functions.ticketdelete')]);
        }else{
           
            $media = $ticket->getMedia('ticket');

            foreach ($media as $media) {
              
                    $media->delete();
                
            }
            $ticket->delete();

            return response()->json(['error'=>trans('langconvert.functions.ticketdelete')]);

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
                $medias = $ticket->comments()->firstOrFail()->getMedia('comments');

                foreach ($medias as $mediass) {
                    
                    $mediass->delete();
                
                }
                $comment->each->delete();
                $ticket->delete();
                return response()->json(['error'=>trans('langconvert.functions.ticketdelete')]);
            }else{
            
                $media = $ticket->getMedia('ticket');

                foreach ($media as $media) {
                
                        $media->delete();
                    
                }
                $ticket->delete();
            }
        }
        return response()->json(['error'=>trans('langconvert.functions.ticketdelete')]);
        
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

        $rating = $ticket->comments()->whereNotNull('user_id')->get();
        $comment = Comment::select('user_id')->where('ticket_id',  $ticket->id)->distinct()->get();
        // $ticket->comments()->select('user_id')->distinct()->get();
        if($rating->isEmpty()){
            return redirect()->back();
        }else{
            return view('user.ticket.rating', compact('ticket', 'comment', 'title','footertext'))->with($data);
        }  
  
    }

        /// rating system ///
        public function star5($id){

            $user = User::with('usetting')->findorFail($id);
            $user->usetting->increment('star5');
            $user->usetting->update();
    
            return redirect('customer/')->with('success', trans('langconvert.functions.ratingsubmit'));
           
        }
    
        public function star4($id){
    
            $user = User::with('usetting')->findorFail($id);
            $user->usetting->increment('star4');
            $user->usetting->update();
    
            
    
            return redirect('customer/')->with('success', trans('langconvert.functions.ratingsubmit'));
           
        }
    
        public function star3($id){
    
            $user = User::with('usetting')->findorFail($id);
            $user->usetting->increment('star3');
            $user->usetting->update();
    
            
    
            return redirect('customer/')->with('success', trans('langconvert.functions.ratingsubmit'));
           
        }
    
    
        public function star2($id){
    
            $user = User::with('usetting')->findorFail($id);
            $user->usetting->increment('star2');
            $user->usetting->update();
    
            return redirect('customer/')->with('success', trans('langconvert.functions.ratingsubmit'));
           
        }
    
        public function star1($id){
    
            $user = User::with('usetting')->findorFail($id);
    
            $user->usetting->increment('star1');
            $user->usetting->update();
            return redirect('customer/')->with('success', trans('langconvert.functions.ratingsubmit'));
        }
        /// end rating system ///

}
