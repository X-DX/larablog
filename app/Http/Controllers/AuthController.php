<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\UserStatus;
use App\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Helpers\CMail;

class AuthController extends Controller
{
    public function loginForm(Request $request){
        $data = [
            'pagesTitle' => 'Login'
        ];
        return view('back.pages.auth.login',$data);
    }

    public function forgotForm(Request $request)
    {
        $data = [
            'pageTitle' => 'Forgot Password'
        ];
        return view('back.pages.auth.forgot',$data);
    }

    public function loginHandler(Request $request){
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if( $fieldType == 'email'){
            $request->validate([
                'login_id' => 'required|email|exists:users,email',
                'password' => 'required|min:5'
            ],[
                'login_id.required'=>'Enter your email or username',
                'login_id.email' => 'Invalid email address',
                'login_id.exists' => 'No account found for this email'
            ]);
        }else{
            $request->validate([
                'login_id' => 'required|exists:users,username',
                'password' => 'required|min:5'
            ],[
                'login_id.required'=>'Enter your email or username',
                'login_id.exists' => 'No account found for this username'
            ]);
        }

        $creds = array(
            $fieldType => $request->login_id,
            'password' => $request->password,
        );

        if( Auth::attempt($creds)){
            // check if account is inactive mode
            if( auth()->user()->status == UserStatus::Inactive){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('fail','Your account is currently inactive. Please, contact at (support@gmail.com) for futher assistance.');
            }

            // check if account is in pending mode
            if( auth()->user()->status == UserStatus::Pending){
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('fail','Your account is currently pending approval. Please, check your email for futher instruction or contact support at (support@gmail.com) assistant');
            }

            // redirect to dashboard
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->route('admin.login')->withInput()->with('fail','Incorrect Password');
        }
        
    }

    public function sendPasswordResetLink(Request $request){
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ],[
            'email.required' => 'The :attribute is required',
            'email.email' => 'Invalid email address',
            'email.exists' => 'We can not find a user with this email address'
        ]);

        // get user details
        $user = User::where('email',$request->email)->first();

        // generate token
        $token = base64_encode(Str::random(64));

        // check if there is an existing token
        $oldToken = DB::table('password_reset_tokens')
                    ->where('email',$user->email)
                    ->first();
        
        if( $oldToken ){
            // update exiting token
            DB::table('password_reset_tokens')
            ->where('email',$user->email)
            ->update([
                'token' => $token,
                'created_at'=>Carbon::now()
            ]);
        }else{
            // add new reset password token
            DB::table('password_reset_tokens')->insert([
                'email'=>$user->email,
                'token'=>$token,
                'created_at'=>Carbon::now()
            ]);
        }

        // Create clickable action link
        $actionLink = route('admin.reset_password_form',['token'=>$token]);

        $data = array(
            'actionlink'=>$actionLink,
            'user'=>$user
        );

        $mail_body = view('email-templates.forgot-template',$data)->render();

        $mailConfig = array(
            'recipient_address'=>$user->email,
            'recipient_name'=>$user->name,
            'subject'=>'Reset Password',
            'body'=>$mail_body
        );

        
        if(CMail::send($mailConfig)){
            return redirect()->route('admin.forgot')->with('success','We have e-mailed your password reset link.');
        }else{
            return redirect()->route('admin.forgot')->with('fail','Something went wrong. Resetting password link not sent. Try again later.');
        }
    }
}
