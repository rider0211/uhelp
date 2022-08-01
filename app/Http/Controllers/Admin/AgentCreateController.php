<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use DB;
use App\Models\User;
use App\Models\Countries;
use App\Models\Timezone;
use Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\Ticket\Category;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\usersettings;
use App\Models\Seosetting;
use App\Models\Pages;
use Session;
use Crypt;
use Illuminate\Support\Str;
use Mail;
use App\Mail\mailmailablesend;
use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use DataTables;

class AgentCreateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('Employee Access');

        $user = User::with('permissions')->get();
        $data['users'] = $user;
     
        $roles = Role::get();
        $data['roles'] = $roles;

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
    
        return view('admin.agent.index')->with($data)->with('i', (request()->input('page', 1) - 1) * 5);
       
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('Employee Create');
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

        $roles = Role::get();
        $data['roles'] = $roles;
        
        return view('admin.agent.agentprofilecreate')-> with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('Employee Create');
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'empid' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required',
            'password' => 'required|string|min:8',
        ]);
        if($request->phone){
            $request->validate([
                'phone' => 'numeric',
            ]);
        }
        
        $user = User::create([
            'firstname' => Str::ucfirst($request->input('firstname')),
            'lastname' => Str::ucfirst($request->input('lastname')),
            'empid' => Str::upper($request->empid),
            'email' => $request->email,
            'status' => '1',
            'password' => Hash::make($request->password),
            'skills' => $request->skills,
            'phone' => $request->phone,
            'image' => null,
            'verified' => '1',
            
        ]);

        $users = User::find($user->id);
        $users->name = $user->firstname.' '.$user->lastname;
        $users->languagues = $request->languages;
        $users->darkmode = setting('DARK_MODE');
        $users->update();
        
        $user->assignRole([$request->role]);


        $usersetting = new usersettings();
        $usersetting->users_id = $users->id;
        $usersetting->save();


       
        $ticketData = [
            'userpassword' => $request->password,
            'username' => $user->firstname .' '. $user->lastname,
            'useremail' => $user->email,
            'url' => url('/admin'),
        ];

        try{

            Mail::to($user->email)
            ->send( new mailmailablesend( 'employee_send_registration_details', $ticketData ) );
        
        }catch(\Exception $e){
            return redirect('admin/employee')->with('success', trans('langconvert.functions.employeecreate'));
        }
        return redirect('admin/employee')->with('success', trans('langconvert.functions.employeecreate'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('Employee Edit');
        $user = User::where('id', $id)->first();
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

        $roles = Role::get();
        $data['roles'] = $roles;
        
        return view('admin.agent.agentprofile')-> with($data);
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
        $this->authorize('Employee Edit');
        $employee = User::find($id);
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
        ]);
        if($request->phone){
            $request->validate([
                'phone' => 'numeric',
            ]);
        }
        if($request->role){
            $request->validate([
                'role' => 'required',
            ]);
        }
        if($request->email == $employee->email){
            $request->validate([
                 'email' => 'required|string|email|max:255',
            ]);
        }else{
            $request->validate([
                 'email' => 'required|string|email|max:255|unique:users',
            ]);
        }
        if($request->empid == $employee->empid){
            $request->validate([
                'empid' => 'required|max:255',
            ]);
        }else{
            $request->validate([
                'empid' => 'required|max:255||unique:users',
            ]);
        }
      
        
        $user = User::where('id', $id)->findOrFail($id);
        $user->firstname = Str::ucfirst($request->input('firstname'));
        $user->lastname = Str::ucfirst($request->input('lastname'));
        if($request->email != $employee->email){
            $user->email = $request->email;
            
        }
        if($request->empid != $employee->empid){
            
            $user->empid = Str::upper($request->empid);
        }
        $user->languagues = $request->languages;
        $user->skills = $request->skills;
        $user->phone = $request->phone;
        if($user->id == 1){
            $user->status = '1';
        }else{
            $user->status = $request->input('status');
        }
            $user->update();
        if(!empty($user->getRoleNames()[0])){
            $user->removeRole( $user->getRoleNames()[0] );
        }
        $user->assignRole($request->role);
       
        $users = User::find($user->id);
        $users->name = $user->firstname.' '.$user->lastname;
        $users->update();
        

        return redirect('admin/employee')->with('success', trans('langconvert.functions.employeeupdate'));
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('Employee Delete');
        $user = User::where('id', $id)->findOrFail($id);

        $user->usetting()->delete();
        $user->usercustomsetting()->delete();
        
        $user->delete();

        return response()->json(['error'=> trans('langconvert.functions.employeedelete')]);
    }

    public function usermassdestroy(Request $request){
        $student_id_array = $request->input('id');
    
        $customers = User::whereIn('id', $student_id_array)->get();
    
        foreach($customers as $user){
         
            $user->usetting()->delete();
            $user->usercustomsetting()->delete();
        
            $user->delete();
        }
        return response()->json(['error'=> trans('langconvert.functions.employeedelete')]);
        
    }

    public function status(Request $request, $id)
    {
        $calID = User::find($id);
        $calID->status = $request->status;
        $calID->save();

        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);

    }

    public function userimportindex(){

        $title = Apptitle::first();
        $data['title'] = $title;

        $footertext = Footertext::first();
        $data['footertext'] = $footertext;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $post = Pages::all();
        $data['page'] = $post;
        

        return view('admin.agent.userimport')->with($data);
    }

     /**
    * @return \Illuminate\Support\Collection
    */
    public function usercsv(Request $req) 
    {
        $this->authorize('Employee Importlist');
        $file = $req->file('file')->store('import');
        
        $import = Excel::import(new UserImport, $file);
     
        return redirect()->route('employee')->with('success', trans('langconvert.functions.employeeimport'));
    }
}
