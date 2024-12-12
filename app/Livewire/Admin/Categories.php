<?php

namespace App\Livewire\Admin;
use App\Models\ParentCategory;
use App\Models\Category;

use Livewire\Component;

class Categories extends Component
{
    public $isUpdateParentCategoryMode = false;
    public $pcategory_id, $pcategory_name;

    public function addParentCategory(){
        $this->pcategory_id = null;
        $this->pcategory_name = null;
        $this->isUpdateParentCategoryMode = false;
        $this->showParentCategoryModalForm();
    }

    public function showParentCategoryModalForm(){
        $this->resetErrorBag();
        $this->dispatch('showParentCategoryModalForm');
    }

    public function hideParentCategoryModalForm(){
        $this->dispatch('hideParentCategoryModalForm');
        $this->isUpdateParentCategoryMode = false;
        $this->pcategory_id = $this->pcategory_name = null;
    }

    public function createParentCategory(){
        $this->validate([
            'pcategory_name' => 'required|unique:parent_categories,name'
        ],[
            'pcategory_name.required' => 'Parent category field is required.',
            'pcategory_name.unique' => 'Parent category name is already exists.'
        ]);

        // store
        $pcategory = new ParentCategory();
        $pcategory->name = $this->pcategory_name;
        $saved = $pcategory->save();

        if($saved){
            $this->hideParentCategoryModalForm();
            $this->dispatch('showSweetAlert',['type'=>'success','message'=>'New Parent Category has been Created Successfully.']);
        }else{
            $this->dispatch('showSweetAlert',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.categories',[
            'pcategories' => ParentCategory::orderBy('ordering','asc')->get()
        ]);
    }
}
