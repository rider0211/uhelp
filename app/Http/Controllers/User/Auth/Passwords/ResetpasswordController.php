<?php

namespace App\Http\Controllers\User\Auth\Passwords;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use DB; 
use App\Models\Customer; 
use Hash;
use App\Models\Apptitle;
use App\Models\Seosetting;

class ResetpasswordController extends Controller
{
    public function resetpassword($token){

        $title = Apptitle::first();
        $data['title'] = $title;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $user = DB::table('password_resets')->where('token', $token)->first();
        $data['user'] = $user;
        
        return view('user.auth.passwords.resetpassword',['token' => $token])->with($data);

    }

    public function updatePassword(Request $request)
    {
  
		$request->validate([
			'email' => 'required|email|exists:customers',
			'password' => 'required|string|min:6|confirmed',
			'password_confirmation' => 'required',
	
		]);
  
    	$updatePassword = DB::table('password_resets')->where(['email' => $request->email, 'token' => $request->token])->first();
  
    	if(!$updatePassword)
        	return back()->withInput()->with('error', 'Invalid token!');

        	$user = Customer::where('email', $request->email)->first();
      	if($user->password == null){

        	$user->update(['password' => Hash::make($request->password)]);

      	}else{
        
        	$user->update(['password' => Hash::make($request->password)]);
     	}
  
      	DB::table('password_resets')->where(['email'=> $request->email])->delete();
  
      	return redirect('/')->with('success', 'Your password has been changed!');
  
    }
}
