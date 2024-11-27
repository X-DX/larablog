<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Illuminate\Http\Request;

class Profile extends Component
{
    public $tab = null;
    public $tabname = 'personal_details';
    protected $queryString = ['tab' => ['keep'=>true]];
    public $name, $email, $username, $bio;

    public function selectTab($tab){
        $this->tab = $tab;
    }

    public function mount(){
        $this->tab = Request('tab') ? Request('tab') : $this->tabname;

        //populate
        $user = User::findOrFail(auth()->id());
        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->bio = $user->bio;
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
            $this->dispatch('showToastr',['type'=>'success','message'=>'Your personal details have been updated successfully.']);
            $this->dispatch('updateTopUserInfo')->to(TopUserInfo::class);
        }else{
            $this->dispatch('showToastr',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.profile',[
            'user'=>User::findOrFail(auth()->id())
        ]);
    }
}
