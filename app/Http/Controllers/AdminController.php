<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminController extends Controller
{
    public function adminDashboard(Request $request)
    {
        $data = [
            'pagesTitle' => 'Dashboard'
        ];
        return view('back.pages.dashboard',$data);
    }

    public function logoutHandler(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('fail','You are now logged out!');
    }

    public function profileView(Request $request){
        $data = [
            'pagesTitle' => 'profile'
        ];
        return view('back.pages.profile',$data);
    }
}
