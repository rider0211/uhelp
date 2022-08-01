<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use App\Models\User;
use App\Models\usersettings;
use App\Models\Customer;
use App\Models\Countries;
use App\Models\Timezone;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use Illuminate\Support\Facades\Validator;
use Hash;
use File;
use Image;
use Illuminate\Support\Str;
use Mail;
use App\Mail\mailmailablesend;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use DataTables;
use Session;
class AdminprofileController extends Controller
{
    public function index()
    {

        $user = User::get();
        $data['users'] = $user;

        $country = Countries::all();
        $data['countries'] = $country;

        $timezones = Timezone::Orderby('offset')->get();
        $data['timezones'] = $timezones;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if(Auth::check() && Auth::user()->id){
            $avgrating1 = usersettings::where('users_id', Auth::id())->sum('star1');
            $avgrating2 = usersettings::where('users_id', Auth::id())->sum('star2');
            $avgrating3 = usersettings::where('users_id', Auth::id())->sum('star3');
            $avgrating4 = usersettings::where('users_id', Auth::id())->sum('star4');
            $avgrating5 = usersettings::where('users_id', Auth::id())->sum('star5');

            $avgr = ((5*$avgrating5) + (4*$avgrating4) + (3*$avgrating3) + (2*$avgrating2) + (1*$avgrating1));
            $avggr = ($avgrating1 + $avgrating2 + $avgrating3 + $avgrating4 + $avgrating5);
            
            if($avggr == 0){
                $avggr = 1;
                $avg = $avgr/$avggr;
            }else{
                $avg = $avgr/$avggr;
            }
            
        }

        return view('admin.profile.adminprofile' ,compact('avg'))-> with($data);

       
    }


    public function profileedit()
    {
        $this->authorize('Profile Edit');
        $user = User::get();
        $data['users'] = $user;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.profile.adminprofileupdate')-> with($data);

       
    }

    public function profilesetup(Request $request){
        $this->authorize('Profile Edit');

        $this->validate($request, [
            'firstname' => 'max:255',
            'lastname' => 'max:255',
        ]);
         if($request->phone){
            $this->validate($request, [
                'phone' => 'numeric',
            ]);
         }


        $user_id = Auth::user()->id;

        $user = User::findOrFail($user_id);

        $user->firstname = ucfirst($request->input('firstname'));
        $user->lastname = ucfirst($request->input('lastname'));
        $user->name = ucfirst($request->input('firstname')).' '.ucfirst($request->input('lastname'));
        $user->gender = $request->input('gender');
        $user->languagues = implode(', ', $request->input('languages'));
        $user->skills = implode(', ', $request->input('skills'));
        $user->phone = $request->input('phone');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileArray = array('image' => $file);
            $rules = array(
                'image' => 'mimes:jpeg,jpg,png|required|max:5120' // max 10000kb
              );
          
              // Now pass the input and rules into the validator
              $validator = Validator::make($fileArray, $rules);

              if ($validator->fails())
                {
                    return redirect()->back()->with('error', trans('langconvert.functions.imagevalidatefails'));
                }else{
                   
                        $destination = 'public/uploads/profile';
                        $image_name = time() . '.' . $file->getClientOriginalExtension();
                        $resize_image = Image::make($file->getRealPath());

                        $resize_image->resize(80, 80, function($constraint){
                        $constraint->aspectRatio();
                        })->save($destination . '/' . $image_name);

                        $destinations = 'public/uploads/profile/'.$user->image;
                        if(File::exists($destinations)){
                            File::delete($destinations);
                        }
                        $file = $request->file('image');
                        $user->update(['image'=>$image_name]);
                    }
            
            
        }
       
       
        $user->update(); 
        return redirect('admin/profile')->with('success', trans('langconvert.functions.profileupdate'));

    }

    public function imageremove(Request $request, $id){

        $user = User::findOrFail($id);

        $user->image = null;
        $user->update();

        return response()->json(['success'=> trans('langconvert.functions.profileimageremove')]);
        
    }


    // Customer function

    public function customers()
    {
        $this->authorize('Customers Access');
        $user = Customer::get();
        $data['users'] = $user;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        if(request()->ajax()) {
            $data = Customer::latest()->get();
            return DataTables::of($data)
            ->addColumn('action', function($data){
                $button = '<div class = "d-flex">';
                if(Auth::user()->can('Customers Edit')){
        
                    $button .= '<a href="'.url('/admin/customer/' . $data->id).'" class="action-btns1" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="feather feather-edit text-primary"></i></a>';
                }else{
                    $button .= '~';
                }
                if(Auth::user()->can('Customers Delete')){
                    $button .= '<a href="javascript:void(0)" class="action-btns1" data-id="'.$data->id.'" id="show-delete" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete"><i class="feather feather-trash-2 text-danger"></i></a>';
                }else{
                    $button .= '~';
                }
                
                $button .= '</div>';
                return $button;
              })
              ->addColumn('checkbox', function($data){
                if(Auth::user()->can('Customers Delete')){
                    return '<input type="checkbox" name="customer_checkbox[]" class="checkall" value="'.$data->id.'" />';
                }else{
                    return '<input type="checkbox" name="customer_checkbox[]" class="checkall" value="'.$data->id.'" disabled />';
                }
            })
            ->addColumn('status', function($data){
                if($data->status == "1"){
                    return '<span class="badge badge-success">Active</span>';
                }
                else{
                    return '<span class="badge badge-danger">Inactive</span>';
                }
                
            
            })
            ->addColumn('verified', function($data){
                if($data->verified == 1){
                 return 'Verified';
                }
                else{
                    return 'Unverified';
                }
            
            })
            ->addColumn('created_at', function($data){
                return '<span class="badge badge-success-light">'.$data->created_at->format(setting('date_format')).'</span>';
            })
            ->addColumn('username', function($data){
                if(auth()->user()->can('Customers Login')){

                    return '<div><a href="#" class="h5">'.Str::limit($data->username, '40').'</a></div>
                    <small class="fs-12 text-muted"> <span class="font-weight-normal1">'.Str::limit($data->email, '40').'</span></small>
                    <a href="'.url("admin/customer/adminlogin/". $data->id).'"  target="_blank"><span class="badge badge-success text-white f-12">'.__('Login as').'</span></a>';
                }else{

                    return '<div><a href="#" class="h5">'.Str::limit($data->username, '40').'</a></div>
                    <small class="fs-12 text-muted"> <span class="font-weight-normal1">'.Str::limit($data->email, '40').'</span></small>';
                }
                
             
            })
            ->addIndexColumn()
            ->rawColumns(['action','checkbox','status','created_at','username'])
            ->make(true);
        }

        return view('admin.customers.index')->with($data)->with('i', (request()->input('page', 1) - 1) * 5);

       
    }
    public function customerscreate()
    {
        $this->authorize('Customers Create');
        $user = Customer::get();
        $data['users'] = $user;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        $country = Countries::all();
        $data['countries'] = $country;

        $timezones = Timezone::Orderby('offset')->get();
        $data['timezones'] = $timezones;

        return view('admin.customers.create')->with($data)->with('i', (request()->input('page', 1) - 1) * 5);

       
    }

    public function customersstore(Request $request){
        $this->authorize('Customers Create');
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8',
        ]);

        if($request->phone){
            $request->validate([
                'phone' => 'numeric',
            ]);
        }
        
        $customer = Customer::create([
            'firstname' => Str::ucfirst($request->input('firstname')),
            'lastname' => Str::ucfirst($request->input('lastname')),
            'email' => $request->email,
            'status' => '1',
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'image' => null,
            'verified' => '1',
            'userType' => 'Customer',
            
        ]);

        $customers = Customer::find($customer->id);
        $customers->username = $customer->firstname.' '.$customer->lastname;
        $customers->update();

        $customerData = [
            'userpassword' => $request->password,
            'username' => $customer->firstname .' '. $customer->lastname,
            'useremail' => $customer->email,
            'url' => url('/'),
        ];

        try{

            Mail::to($customer->email)
            ->send( new mailmailablesend( 'customer_send_registration_details', $customerData ) );
        
        }catch(\Exception $e){
            return redirect('admin/customer')->with('success', trans('langconvert.functions.customercreate'));
        }
        return redirect('admin/customer')->with('success', trans('langconvert.functions.customercreate'));

    }

    public function customersshow($id){
        $this->authorize('Customers Edit');
        $user = Customer::where('id', $id)->first();
        $data['user'] = $user;

        $country = Countries::all();
        $data['countries'] = $country;

        $timezones = Timezone::Orderby('offset')->get();
        $data['timezones'] = $timezones;

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;

        return view('admin.customers.show')->with($data);

    }

    public function customersupdate(Request $request, $id)
    {
        $this->authorize('Customers Edit');
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
        ]);

        if($request->phone){
            $request->validate([
                'phone' => 'numeric',
            ]);
        }
        $user = Customer::where('id', $id)->findOrFail($id);
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->username = $request->input('firstname').' '.$request->input('lastname');
        $user->email = $request->input('email');
        $user->country = $request->input('country');
        $user->timezone = $request->input('timezone');
        $user->status = $request->input('status');
        $user->update();
        $request->session()->forget('email',$user->email);

        return redirect('/admin/customer')->with('success', trans('langconvert.functions.customerupdate'));
      
    }

    public function adminLogin($id)
    {
        $customerExist = Customer::where(['id' => $id, 'status' => 0])->exists();
        if ($customerExist) {
            return redirect()->back()->with('error', trans('langconvert.functions.customerinactive'));
        }
        Auth::guard('customer')->loginUsingId($id, true);
        return redirect()->intended('customer/');
    }

    public function customersdelete($id){
        $this->authorize('Customers Delete');
        $user = Customer::findOrFail($id);
        $ticket = $user->tickets()->get();

            foreach ($ticket as $tickets) {
                foreach ($tickets->getMedia('ticket') as $media) {
                    $media->delete();
                }  
                foreach($tickets->comments as $comment){
                    foreach($comment->getMedia('comments') as $media){
                        $media->delete();
                    }
                    $comment->delete();
                }
            $tickets->delete();
        }
        $user->custsetting()->delete();
        $user->customercustomsetting()->delete();
        $user->delete();

        return response()->json(['error'=> trans('langconvert.functions.customerdelete')]);
    }


    public function customermassdestroy(Request $request){
        $student_id_array = $request->input('id');
    
        $customers = Customer::whereIn('id', $student_id_array)->get();
    
        foreach($customers as $customer){
         
            foreach ($customer->tickets()->get() as $tickets) {
                foreach ($tickets->getMedia('ticket') as $media) {
                    $media->delete();
                }
                foreach($tickets->comments as $comment){
                    foreach($comment->getMedia('comments') as $media){
                        $media->delete();
                    }
                    $comment->delete();
                } 
                $tickets->delete();
            } 
            $customer->custsetting()->delete();
            $customer->customercustomsetting()->delete();
            $customer->delete();
        }
        return response()->json(['error'=> trans('langconvert.functions.customerdelete')]);
        
    }

    public function usersetting(Request $request)
    {
        $users = User::find($request->user_id);
        $users->darkmode = $request->dark;
        $users->update();
        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);

    }


}
