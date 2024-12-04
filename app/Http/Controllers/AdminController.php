<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\File;
use SawaStacks\Utils\Kropify;

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

    public function updateProfilePictute(Request $request)  {
        $user = User::findOrFail(auth()->id());
        $path = "images/users/";
        $file = $request->file('profilePictureFile');
        $old_picture = $user->getAttributes()['picture'];
        $filename = 'IMG_' . uniqid() . '.png';
        // return response()->json([
        //     'status' => 0,
        //     'message' => 'Something went wrong',
        //     'file' => $file ? [
        //         'original_name' => $file->getClientOriginalName(),
        //         'size' => $file->getSize(),
        //         'mime_type' => $file->getMimeType(),
        //     ] : null,
        //     'filename' => $filename,
        //     'old_picture' => $old_picture,
        //     'path' => public_path($path.$old_picture)
        // ]);



        $upload = Kropify::getFile($file, $filename)->maxWoH(255)->save($path);

        if($upload){
            // Delete old profile pictute if exits
            if( $old_picture != null && File::exists(public_path($path.$old_picture))){
                File::delete(public_path($path.$old_picture));
            }
            // update profile pictute in DB
            $user->update(['picture'=>$filename]);
            return response()->json(['status'=>1,'message'=>'Your Profile picture has been updated successfully.']);
        }else{
            return response()->json(['status'=>0,'message'=>'Something went wrong']);
        }
    }
}
