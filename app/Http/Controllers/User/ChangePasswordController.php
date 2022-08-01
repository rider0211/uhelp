<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Hash, Auth;
use App\Models\Customer;

class ChangePasswordController extends Controller
{

   
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('user.auth.passwords.changepassword');
    } 
   
  

    public function changePassword(Request $request)
    {
        
        $request->validate([
          'current_password' => 'required|max:255',
          'password' => 'required|string|min:8|max:255|confirmed',
          'password_confirmation' => 'required|max:255',
        ]);

        $user = Auth::guard('customer')->user();
        dd(Hash::check($request->current_password, $user->password));
        if (Hash::check($request->current_password, $user->password)) {

            $user->password = Hash::make($request->password);
            $user->save();

            Auth::guard('customer')->logout();
            return  redirect()->route('auth.login')->with('success', trans('langconvert.functions.changepassword'));
        }
        else{
            return back()->with('error', trans('langconvert.functions.changepasswordnotmatch'));
        }

        
    }
}
