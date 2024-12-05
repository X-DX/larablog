<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Http\Request;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Hash;
Use Illuminate\Support\Facades\Session;
use App\Helpers\CMail;
use Illuminate\Support\Facades\Auth;
use App\Models\UserSocialLink;

use function Illuminate\Log\log;

class Profile extends Component
{
    use LivewireAlert;
    public $tab = null;
    public $tabname = 'personal_details';
    protected $queryString = ['tab' => ['keep'=>true]];
    public $name, $email, $username, $bio;
    public $current_password, $new_password, $new_password_confirmation;
    public $facebook_url, $instagram_url, $youtube_url, $linkedin_url, $twitter_url, $github_url;

    protected $listeners = [
        'updateProfile' => '$refresh'
    ];

    public function selectTab($tab){
        $this->tab = $tab;
    }

    public function mount(){
        $this->tab = Request('tab') ? Request('tab') : $this->tabname;

        //populate
        $user = User::with('social_links')->findOrFail(auth()->id());
        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->bio = $user->bio;

        // populate Social Link Form
        if( !is_null($user->social_links)){
            $this->facebook_url = $user->social_links->facebook_url;
            $this->instagram_url = $user->social_links->instagram_url;
            $this->youtube_url = $user->social_links->youtube_url;
            $this->linkedin_url = $user->social_links->linkedin_url;
            $this->twitter_url = $user->social_links->twitter_url;
            $this->github_url = $user->social_links->github_url;

        }
    }

    public function updatePersonalDetails(){
        $user = User::findOrFail(auth()->id());
        $this->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,'.$user->id,
        ]);

        //Update User Info
        $user->name = $this->name;
        $user->username = $this->username;
        $user->bio = $this->bio;
        $updated = $user->save();

        sleep(0.5);

        // display message
        if($updated){
            $this->dispatch('showSweetAlert',['type'=>'success','message'=>'Your personal details have been updated successfully.']);
    
            $this->dispatch('updateTopUserInfo')->to(TopUserInfo::class);
        }else{
            $this->dispatch('showSweetAlert',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function updatePassword(){
        $user = User::findOrFail(auth()->id());

        // validate Form
        $this->validate([
            'current_password' => [
                'required',
                'min:5',
                function($attribute, $value, $fail) use ($user){
                    if(!Hash::check($value,$user->password)){
                        return $fail(__('Your current password does not match our records.'));
                    }
                }
            ],
            'new_password' => 'required|min:5|confirmed'
        ]);

        // update User Password
        $updated = $user->update([
            'password'=>Hash::make($this->new_password)
        ]);

        if($updated){
            // send email notification to this user
            $data = array(
                'user' => $user,
                'new_password' => $this->new_password
            );

            $mail_body = view('email-templates.password-change-template',$data)->render();

            $mail_config = array(
                'recipient_address' => $user->email,
                'recipient_name' => $user->name,
                'subject' => 'Password Changed',
                'body' => $mail_body
            );

            CMail::send($mail_config);

            //Logout and Redirect User to login
            auth()->logout();
            Session::flash('info','Your Password has been successfully changed. Please login with your new password.');
            $this->redirectRoute('admin.login');

        }else{
            $this->dispatch('showSweetAlert',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function updateSocialLinks(){
        $this->validate([
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'github_url' => 'nullable|url',
        ]);

        // update the social links details in db
        $user = User::findOrfail(auth()->id());

        $data = array(
            'facebook_url' => $this->facebook_url,
            'instagram_url' => $this->instagram_url,
            'youtube_url' => $this->youtube_url,
            'linkedin_url' => $this->linkedin_url,
            'twitter_url' => $this->twitter_url,
            'github_url' => $this->github_url,
        );

        if( !is_null($user->social_links)){
            // update records
            $query = $user->social_links()->update($data);
        }else{
            // insert new data 
            $data['user_id'] = $user->id;
            $query = UserSocialLink::insert($data);
        }

        if($query){
            $this->dispatch('showSweetAlert',['type'=>'success','message'=>'Your Social Links have been updated Successfully.']);
        }else{
            $this->dispatch('showSweetAlert',['type'=>'error','message'=>'Something went wrong']);
        }
    }

    public function render()
    {
        return view('livewire.admin.profile',[
            'user'=>User::findOrFail(auth()->id())
        ]);
    }
}
