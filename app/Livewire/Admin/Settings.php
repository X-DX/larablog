<?php

namespace App\Livewire\Admin;

use GuzzleHttp\Psr7\Request;
use Livewire\Component;
use App\Models\GeneralSetting;
use Generator;

class Settings extends Component
{
    public $tab = null;
    public $default_tab = 'general_settings';
    protected $queryString = ['tab' =>['keep'=>true]];

    //General Setting Form Properties
    public $site_title, $site_email, $site_phone, $site_meta_desciption, $site_logo, $site_favicon, $site_meta_keywords;

    public function selectTab($tab){
        $this->tab =$tab;
    }

    public function mount(){
        $this->tab = Request('tab') ? Request('tab') : $this->default_tab;

        // Populate general Settings
        $settings = GeneralSetting::take(1)->first();
        if( !is_null($settings)){
            $this->site_title = $settings->site_title;
            $this->site_email = $settings->site_email;
            $this->site_phone = $settings->site_phone;
            $this->site_meta_keywords = $settings->site_meta_keywords;
            $this->site_meta_desciption = $settings->site_meta_desciption;
        }
    }

    public function updateSiteInfo(){
        $this->validate([
            'site_title' => 'required',
            'site_email' => 'required|email'
        ]);

        $settings = GeneralSetting::take(1)->first();
        $data = array(
            'site_title' => $this->site_title,
            'site_email' => $this->site_email,
            'site_phone' => $this->site_phone,
            'site_meta_keywords' => $this->site_meta_keywords,
            'site_meta_desciption' => $this->site_meta_desciption,
        );
        if( !is_null($settings)){
            $query = $settings->update($data);
        }else{
            $query = GeneralSetting::insert($data);
        }

        if($query){
            $this->dispatch('showSweetAlert',['type'=>'success','message'=>'General Setting have been updated Successfully.']);
        }else{
            $this->dispatch('showSweetAlert',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.settings');
    }
}
