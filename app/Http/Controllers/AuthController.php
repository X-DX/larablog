<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\UserStatus;
use App\UserType;
// use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Auth;


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
}
