<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\Models\Apptitle;
use App\Models\Seosetting;
use App\Models\User;
use Hash;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;


    public function showResetForm(Request $request, $token){
        $title = Apptitle::first();
        $data['title'] = $title;

        $seopage = Seosetting::first();
        $data['seopage'] = $seopage;

        $users = DB::table('password_resets')->where('token', $token)->first();
        $data['users'] = $users;

        $token = $request->route()->parameter('token');
        
        return view('admin.auth.passwords.resetpassword')->with(
            ['token' => $token, 'email' => $request->email]
        )->with($data);
    }

    public function reset(Request $request){

        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required',
      
        ]);
      
        $updatePassword = DB::table('password_resets')
                        ->where(['email' => $request->email, 'token' => $request->token])
                        ->first();
      
        if(!$updatePassword)
        return back()->withInput()->with('error', 'Invalid token!');
    
        $user = User::where('email', $request->email)->first();
        if($user->password == null){
    
            $user->update(['password' => Hash::make($request->password)]);
    
        }else{
            
            $user->update(['password' => Hash::make($request->password)]);
        }
      
        DB::table('password_resets')->where(['email'=> $request->email])->delete();
      
        return redirect()->route('login')->with('success', 'Your password has been changed!');
      

    }
}
