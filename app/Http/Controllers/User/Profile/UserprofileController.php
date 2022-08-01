<?php

namespace App\Http\Controllers\User\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\CustomerSetting;
use App\Models\Countries;
use App\Models\Timezone;
use Auth;
use Hash;
use File;
use App\Models\Apptitle;
use App\Models\Footertext;
use App\Models\Seosetting;
use App\Models\Pages;
use Illuminate\Support\Facades\Validator;
use Image;


class UserprofileController extends Controller
{

    public function profile(){
            
        
        $user = Customer::get();
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


        return view ('user.profile.userprofile')->with($data);
            

    }
    
    public function profilesetup(Request $request){

        $this->validate($request, [
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
        ]);
        if($request->phone){
            $this->validate($request, [
                'phone' => 'numeric|min:10',
            ]);
        }


        $user_id = Auth::guard('customer')->user()->id;

        $user = Customer::findOrFail($user_id);

        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->username = $request->input('firstname') .' '. $request->input('lastname');
        $user->country = $request->input('country');
        $user->timezone = $request->input('timezone');
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
        return redirect()->back()->with('success', trans('langconvert.functions.profileupdate'));

    }

    public function imageremove(Request $request, $id){

        $user = Customer::findOrFail($id);

        $user->image = null;
        $user->update();

        return response()->json(['success'=>trans('langconvert.functions.profileimageremove')]);
        
    }


    public function profiledelete($id){
        
        $user = Customer::findOrFail($id);

        Auth::guard('customer')->logout();
        
        $ticket = $user->tickets()->get();

            foreach ($ticket as $tickets) {
                foreach ($tickets->getMedia('ticket') as $media) {
                    $media->delete();
                }
                foreach($tickets->comments()->get() as $comment ){

                    foreach ($comment->getMedia('comments') as $media) {
                        $media->delete();
                    }

                    $comment->delete();

                }  
           
            $tickets->delete();

        }
        $user->custsetting()->delete();
  
        $user->delete();
        return response()->json(['error'=> trans('langconvert.functions.accountdelete')]);

    }

    public function custsetting(Request $request)
    {
        $users = Customer::with('custsetting')->find($request->cust_id);

        if($users->custsetting != null){

        $users->custsetting->darkmode = $request->dark;
        $users->custsetting->update();

        }else {
            $custsettings = CustomerSetting::create([
            'custs_id' => $request->cust_id,
            'darkmode' => $request->dark

            ]);
        }
        
        return response()->json(['code'=>200, 'success'=> trans('langconvert.functions.updatecommon')], 200);

    }


	
}

   