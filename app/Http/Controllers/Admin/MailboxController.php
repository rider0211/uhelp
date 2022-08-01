<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\User;
use App\Models\Customer;
use App\Models\Sendmail;
use App\Models\senduserlist;
use Auth;
use Session;
use DataTables;
use App\Notifications\CustomerCustomNotifications;
use App\Mail\AppMailer;
use Str;


class MailboxController extends Controller
{
    public function index(){

        $this->authorize('Custom Notifications Access');
       
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;
        
        if(request()->ajax()){

            $data = Sendmail::latest()->get();
            return DataTables::of($data)
            ->addColumn('user', function($data){
                    $v = $data->touser()->paginate(1);
                foreach($v as $submail){
                    if($submail->touser != null){
                        if( $v > '1'){
                            $user = 'Multiple Employees';
                        }else{
                            $user = ''.Str::limit($submail->touser->name, '40').' ('.Str::limit($submail->touser->getRoleNames()[0], '40').')';
                        }
                    return $user;
                    }
                    if($submail->tocust_id != null){
                        if( $v > '1'){
                            $cust = 'Multiple Customers';
                        }else{
                            $cust = ''.Str::limit($submail->tocust->username, '40').'';
                        }
                        return $cust;
                    }
                }
                
            })
            ->addColumn('usertype', function($data){
                $v = $data->touser()->get();
                foreach($v as $submail){
                    if($submail->touser != null){
                        
                    return 'Employees';
                    }
                    if($submail->tocust_id != null){
                        if($submail->tocust->userType == 'Customer'){
                            return 'Customer';
                        }
                    }
                }
            
            })
            ->addColumn('action', function($data){
                $button = '<div class = "d-flex">';
                if(Auth::user()->can('Custom Notifications View')){
        
                    $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" onclick="viewc(event.target)" class="action-btns1 edit-testimonial"><i class="feather feather-eye text-primary" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="View"></i></a>';
                }else{
                    $button .= '~';
                }
                if(Auth::user()->can('Custom Notifications Delete')){
                    $button .= '<a href="javascript:void(0)" data-id="'.$data->id.'" class="action-btns1" onclick="deletecustom(event.target)" ><i class="feather feather-trash-2 text-danger" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"></i></a>';
                }else{
                    $button .= '~';
                }
                
                $button .= '</div>';
                return $button;
            })
            ->addColumn('checkbox', function($data){
                if(Auth::user()->can('Project Delete')){
                    return '<input type="checkbox" name="custom_checkbox[]" class="checkall" value="'.$data->id.'" />';
                }else{
                    return '<input type="checkbox" name="custom_checkbox[]" class="checkall" value="'.$data->id.'" disabled />';
                }
            })
            ->addColumn('mailsubject', function($data){
                return Str::limit($data->mailsubject, '40');
            })
            ->rawColumns(['action','checkbox','mailsubject'])
            ->addIndexColumn()
            ->make(true);
        }

        return view('admin.custom-notification.index')->with($data);
    }

    public function customercompose(){
        $this->authorize('Custom Notifications Customer');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $user = Customer::where('userType','Customer')->get();
        $data['users'] = $user;

        return view('admin.custom-notification.customercompose')->with($data);
    }

    public function customercomposesend(Request $request)
    {
        $this->authorize('Custom Notifications Customer');
        $request->validate([
            'message' => 'required',
            'subject' => 'required|max:255',
            'users' => 'required',
        ]);
        $mailsend = new Sendmail();
        $mailsend->user_id = Auth::id();
        $mailsend->mailsubject = $request->input('subject');
        $mailsend->mailtext = $request->input('message');
        $mailsend->save();

        foreach($request->users as $value){
            senduserlist::create([
                'mail_id' => $mailsend->id,
                'tocust_id' => $value,
            ]);
        }
        
        $cust = Customer::find($request->users);
       
        foreach($cust as $value){
            
            $value->notify(new CustomerCustomNotifications($mailsend));
        }
        
        
        return redirect('admin/customnotification')->with('success', trans('langconvert.functions.customersendnotify'));
       
    }

    public function employeecompose(){
        $this->authorize('Custom Notifications Employee');
        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $user = User::get();
        $data['users'] = $user;

        return view('admin.custom-notification.employeecompose')->with($data);
    }


    public function employeecomposesend(Request $request){
        $this->authorize('Custom Notifications Employee');
        $request->validate([
            'message' => 'required',
            'subject' => 'required|max:255',
            'users' => 'required',
        ]);
        $mailsend = new Sendmail();
        $mailsend->user_id = Auth::id();
        $mailsend->mailsubject = $request->input('subject');
        $mailsend->mailtext = $request->input('message');
        $mailsend->save();

        foreach($request->users as $value){
            senduserlist::create([
                'mail_id' => $mailsend->id,
                'touser_id' => $value,
            ]);
        }
        $cust = User::find($request->users);
        foreach($cust as $value){
            
            $value->notify(new CustomerCustomNotifications($mailsend));
        }

        
        
        return redirect('admin/customnotification')->with('success', trans('langconvert.functions.employeesendnotify'));
        
       
    }

    public function mailsent(){

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $sendmails = Sendmail::latest()->get();
        $data['sendmails'] = $sendmails;
        
        return view('admin.custom-notification.sendmail')->with($data);
    }

    public function show($id){
        $this->authorize('Custom Notifications View');
        $custom = Sendmail::find($id);

        return response()->json($custom);
    }

    public function destroy($id)
    {
        $this->authorize('Custom Notifications Delete');
        $customdelete = Sendmail::find($id);
        $customdelete->touser()->delete();
        $customdelete->delete();
  
      return response()->json(['error'=> trans('langconvert.functions.customnotifydelete')]);
    }

    public function allnotifydelete(Request $request){
        $id_array = $request->input('id');
    
        $sendmails = Sendmail::whereIn('id', $id_array)->get();
    
        foreach($sendmails as $sendmail){
            $sendmail->touser()->delete();
            $sendmail->delete();
           
        }
        return response()->json(['error'=> trans('langconvert.functions.customnotifydelete')]);
        
    }
}
