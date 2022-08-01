<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ticket\Ticket;
use Auth;
use App\Models\User;
use App\Models\usersettings;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use App\Models\Customer;
use App\Models\Groupsusers;
use DB;
use DataTables;
use Carbon\Carbon;
use Session;
use Illuminate\Support\Str;


class AdminDashboardController extends Controller
{

    public function index()
    {
        $groupexists = Groupsusers::where('users_id', Auth::id())->exists();

        // if there in group get group tickets
        if($groupexists){
            // total ticket count
            $tickets  = Ticket::select('tickets.*',"groups_categories.group_id","groups_users.users_id")
            ->leftJoin('groups_categories','groups_categories.category_id','tickets.category_id')
            ->leftJoin('groups_users','groups_users.groups_id','groups_categories.group_id')
            ->whereNotNull('groups_users.users_id')
            ->where('groups_users.users_id', Auth::id())
            ->get();
            // Active ticket Count
            $active  = Ticket::select('tickets.*',"groups_categories.group_id","groups_users.users_id")
            ->leftJoin('groups_categories','groups_categories.category_id','tickets.category_id')
            ->leftJoin('groups_users','groups_users.groups_id','groups_categories.group_id')
            ->whereIn('tickets.status', ['New', 'Re-Open','Inprogress'])
            ->whereNotNull('groups_users.users_id')
            ->where('groups_users.users_id', Auth::id())
            ->get();
            // Closed Ticket Count
            $closed  = Ticket::select('tickets.*',"groups_categories.group_id","groups_users.users_id")
            ->leftJoin('groups_categories','groups_categories.category_id','tickets.category_id')
            ->leftJoin('groups_users','groups_users.groups_id','groups_categories.group_id')
            ->where('tickets.status', 'Closed')
            ->whereNotNull('groups_users.users_id')
            ->where('groups_users.users_id', Auth::id())
            ->get();
            // OnHold Ticket Count
            $onhold  = Ticket::select('tickets.*',"groups_categories.group_id","groups_users.users_id")
            ->leftJoin('groups_categories','groups_categories.category_id','tickets.category_id')
            ->leftJoin('groups_users','groups_users.groups_id','groups_categories.group_id')
            ->where('tickets.status', 'On-Hold')
            ->whereNotNull('groups_users.users_id')
            ->where('groups_users.users_id', Auth::id())
            ->get();
            $data['onhold'] = $onhold;
            //myticket count
            $myticket = Ticket::where('user_id', auth()->id())->get();
            $data['myticket'] = $myticket;
            //assignedticket count
            $assigned = Ticket::where('myassignuser_id', Auth::id())->get();
            $data['assigned'] = $assigned;
            //myasssignedticket count
            $myassigned = Ticket::where('toassignuser_id', Auth::id())->get();
            $data['myassigned'] = $myassigned;
            //overdue ticket count
            $overdue = Ticket::select('tickets.*',"groups_categories.group_id","groups_users.users_id")
            ->leftJoin('groups_categories','groups_categories.category_id','tickets.category_id')
            ->leftJoin('groups_users','groups_users.groups_id','groups_categories.group_id')
            ->whereIn('overduestatus', ['Overdue'])
            ->whereNotNull('groups_users.users_id')
            ->where('groups_users.users_id', Auth::id())
            ->get();
            $data['overdue'] = $overdue;
            
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
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"><i class="fe fe-x" ></i></a>
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
            
            $tickets  = Ticket::get();
            $active = Ticket::whereIn('status', ['New', 'Re-Open','Inprogress'])->get();
            $closed = Ticket::where('status', 'Closed')->get();
            $onhold = Ticket::where('status', 'On-Hold')->get();
            $data['onhold'] = $onhold;
            $myticket = Ticket::where('user_id', auth()->id())->get();
            $data['myticket'] = $myticket;
            $assigned = Ticket::where('myassignuser_id', Auth::id())->get();
            $data['assigned'] = $assigned;
            $myassigned = Ticket::where('toassignuser_id', Auth::id())->get();
            $data['myassigned'] = $myassigned;
            $overdue = Ticket::whereIn('overduestatus', ['Overdue'])->get();
            $data['overdue'] = $overdue;

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
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"><i class="fe fe-x" ></i></a>
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
        }
           
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;
    
            
            
        return view('admin.dashboard', compact('tickets','active','closed'))->with($data);

    }

    public function activeticket(){
        $this->authorize('Active Tickets');

        $groupexists = Groupsusers::where('users_id', Auth::id())->exists();

        // if there in group get group tickets
        if($groupexists){
            if(request()->ajax()) {
                $data = Ticket::select('tickets.*',"groups_categories.group_id","groups_users.users_id")
                ->leftJoin('groups_categories','groups_categories.category_id','tickets.category_id')
                ->leftJoin('groups_users','groups_users.groups_id','groups_categories.group_id')
                ->whereIn('tickets.status', ['New', 'Re-Open','Inprogress'])
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
                $data = Ticket::whereIn('status', ['New', 'Re-Open','Inprogress'])->latest('updated_at')->get();
        
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
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"><i class="fe fe-x" ></i></a>
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
        }

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;
        return view('admin.userticket.viewticket.activeticket' )->with($data);
        
    }

    public function closedticket(){

        $groupexists = Groupsusers::where('users_id', Auth::id())->exists();

        // if there in group get group tickets
        if($groupexists){
            if(request()->ajax()) {
                $data = Ticket::select('tickets.*',"groups_categories.group_id","groups_users.users_id")
                ->leftJoin('groups_categories','groups_categories.category_id','tickets.category_id')
                ->leftJoin('groups_users','groups_users.groups_id','groups_categories.group_id')
                ->whereIn('tickets.status', ['Closed'])
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
                $data = Ticket::whereIn('status', ['Closed'])->latest('updated_at')->get();
        
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
                                
                                <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"><i class="fe fe-x" ></i></a>
                                </div>
                                ';
                
                            }else{
                                $toassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">
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
        }

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.userticket.viewticket.closedticket')->with($data);
    }

    public function assignedTickets()
    {
        $this->authorize('Assigned Tickets');
        
        if(request()->ajax()) {
            $data = Ticket::where('myassignuser_id', Auth::id())->latest('updated_at')->get();
    
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
                            
                            <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"><i class="fe fe-x" ></i></a>
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
     

        $active = Ticket::whereIn('status', ['New', 'Re-Open','Inprogress'])->get();

        $closed = Ticket::where('status', 'Closed')->get();

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

        $customer = User::count();
        $data['customer'] = $customer;

        return view('admin.assignedtickets.index', compact('active','closed'))->with($data);
    }

    public function myassignedTickets()
    {
        $this->authorize('My Assigned Tickets');
        
            if(request()->ajax()) {
                $data = Ticket::where('toassignuser_id', Auth::id())->latest('updated_at')->get();
        
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
                ->addColumn('myassignuser_id', function($data){
                    if(Auth::user()->can('Ticket Assign')){
                    if($data->myassignuser == null){
                        $myassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                        Assign
                        </a>';
                    }
                    else{
                        if($data->myassignuser_id != null){
                            $myassignuser_id = '
                            <div class="btn-group btn-group-sm" role="group" aria-label="Basic outlined example">
                            
                            <a href="javascript:void(0)" data-id="' .$data->id.'"  class="btn btn-outline-primary" id="assigned" data-bs-toggle="tooltip" data-bs-placement="top" title="Change">'.$data->myassignuser->name.'</a>
                            
                            <a href="javascript:void(0)" data-id="' .$data->id.'" class="btn btn-outline-primary" id="btnremove" ><i class="fe fe-x" data-bs-toggle="tooltip" data-bs-placement="top" title="Unassign"></i></a>
                            </div>
                            ';
            
                        }else{
                            $myassignuser_id = '<a href="javascript:void(0)" data-id="'.$data->id.'" id="assigned" class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Assign">
                        Assign
                        </a>';
                        }
                    }
                    }else{
                        $myassignuser_id = $data->myassignuser->name;
                    }
                    return $myassignuser_id;
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
                ->rawColumns(['action','cust_id','subject','status','priority','created_at','myassignuser_id','last_reply','ticket_id','checkbox'])
                ->addIndexColumn()
                ->make(true);
                
            }
      

        $active = Ticket::whereIn('status', ['New', 'Re-Open','Inprogress'])->get();

        $closed = Ticket::where('status', 'Closed')->get();

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

        $customer = User::count();
        $data['customer'] = $customer;

        return view('admin.assignedtickets.myassignedticket', compact('active','closed'))->with($data);
    }

    public function onholdticket()
    {
        $this->authorize('Onhold Tickets');


        $groupexists = Groupsusers::where('users_id', Auth::id())->exists();

        // if there in group get group tickets
        if($groupexists){
            if(request()->ajax()) {
                $data = Ticket::select('tickets.*',"groups_categories.group_id","groups_users.users_id")
                ->leftJoin('groups_categories','groups_categories.category_id','tickets.category_id')
                ->leftJoin('groups_users','groups_users.groups_id','groups_categories.group_id')
                ->where('status','On-Hold')
                ->whereNotNull('groups_users.users_id')
                ->where('groups_users.users_id', Auth::id())
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
                $data = Ticket::where('status','On-Hold')->latest('updated_at')->get();
        
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
        }

        $title = Apptitle::first();
        $data['title'] = $title;
    
        $footertext = Footertext::first();
        $data['footertext'] = $footertext;
    
        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;
    
        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.assignedtickets.onholdtickets')->with($data);
    }
    
    
    public function overdueticket()
    {
        $this->authorize('Overdue Tickets');

        $groupexists = Groupsusers::where('users_id', Auth::id())->exists();

        // if there in group get group tickets
        if($groupexists){
            if(request()->ajax()) {
                $data = Ticket::select('tickets.*',"groups_categories.group_id","groups_users.users_id")
                ->leftJoin('groups_categories','groups_categories.category_id','tickets.category_id')
                ->leftJoin('groups_users','groups_users.groups_id','groups_categories.group_id')
                ->whereIn('overduestatus', ['Overdue'])
                ->whereNotNull('groups_users.users_id')
                ->where('groups_users.users_id', Auth::id())
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
                $data = Ticket::whereIn('overduestatus', ['Overdue'])->latest('updated_at')->get();
        
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
        }

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $tickets = Ticket::whereIn('overduestatus', ['Overdue'])->get();
    
        return view('admin.assignedtickets.overdueticket', compact('tickets'))->with($data);
    }
        
    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }
  

    public function autorefresh(Request $request, $id)
    {
        $calID = User::with('usetting')->find($id);
        if($calID->usetting == null){
            $usersettings = new usersettings();
            $usersettings->users_id = $request->id;
            $usersettings->ticket_refresh = $request->status;
            $usersettings->save();
        }
        else{
            $calID->usetting->ticket_refresh = $request->status;
            $calID->usetting->save();
        }
        
        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);

    }
}
