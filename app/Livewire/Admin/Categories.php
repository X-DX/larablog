<?php

namespace App\Livewire\Admin;
use App\Models\ParentCategory;
use App\Models\Category;

use Livewire\Component;

class Categories extends Component
{
    public $isUpdateParentCategoryMode = false;
    public $pcategory_id, $pcategory_name;
    public $isUpdateCategoryMode = false;
    public $category_id, $parent = 0, $category_name;

    protected $listeners = [
        'updateParentCategoryOrdering',
        'updateCategoryOrdering',
        'deleteParentCategoryAction',
        'deleteCategoryAction'
    ];

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

    public function editParentCategory($id){
        $pcategory = ParentCategory::findOrFail($id);
        $this->pcategory_id = $pcategory->id;
        $this->pcategory_name = $pcategory->name;
        $this->isUpdateParentCategoryMode = true;
        $this->showParentCategoryModalForm();
    }

    public function updateParentCategory(){
        $pcategory = ParentCategory::findOrFail($this->pcategory_id);
        $this->validate([
            'pcategory_name' => 'required|unique:parent_categories,name,'.$pcategory->id
        ],[
            'pcategory_name.required' => 'Parent category field is required.',
            'pcategory_name.unique' => 'Parent category name is taken.'
        ]);

        // update the parent category details
        $pcategory->name = $this->pcategory_name;
        $pcategory->slug = null;
        $updated = $pcategory->save();

        if($updated){
            $this->hideParentCategoryModalForm();
            $this->dispatch('showSweetAlert',['type'=>'success','message'=>'Parent Category has been updated Successfully.']);
        }else{
            $this->dispatch('showSweetAlert',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function updateParentCategoryOrdering($positions){
        // dd($positions);
        foreach($positions as $position){
            $index = $position[0];
            $new_position = $position[1];
            ParentCategory::where('id',$index)->update([
                'ordering' => $new_position
            ]);
            $this->dispatch('showSweetAlert',['type'=>'success','message'=>'Parent Categories ordering have been updated successfully.']);
        }
    }

    public function deleteParentCategory($id){
        $this->dispatch('deleteParentCategory',['id'=>$id]);
    }

    public function deleteParentCategoryAction($id){
        $pcategory = ParentCategory::findOrFail($id);

        // check if this parent category as childern

        // Delete parent category
        $delete = $pcategory->delete();
        if( $delete ){
            $this->dispatch('showSweetAlert',['type'=>'success','message'=>'Parent Category has been deleted Successfully.']);
        }else{
            $this->dispatch('showSweetAlert',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function addCategory(){
        // dd("Data");
        $this->category_id = null;
        $this->parent = 0;
        $this->category_name = null;
        $this->isUpdateCategoryMode = false;
        $this->showCategoryModalForm();
    }

    public function showCategoryModalForm(){
        $this->resetErrorBag();
        $this->dispatch('showCategoryModalForm');
    }

    public function hideCategoryModalForm(){
        $this->dispatch('hideCategoryModalForm');
        $this->isUpdateCategoryMode = false;
        $this->category_id = $this->category_name = null;
        $this->parent = 0;
    }

    public function createCategory(){
        $this->validate([
            'category_name' => 'required|unique:categories,name'
        ],[
            'category_name.required' => 'Category field is required',
            'category_name.unique' => 'Category name is already exists.'
        ]);

        // store new category
        $category = new Category();
        $category->parent = $this->parent;
        $category->name = $this->category_name;
        $saved = $category->save();

        if($saved){
            $this->hideCategoryModalForm();
            $this->dispatch('showSweetAlert',['type'=>'success','message'=>'New Category has been created Successfully.']);
        }else{
            $this->dispatch('showSweetAlert',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function editCategory($id){
        $category = Category::findOrFail($id);
        $this->category_id = $category->id;
        $this->parent = $category->parent;
        $this->category_name = $category->name;
        $this->isUpdateCategoryMode = true;
        $this->showCategoryModalForm();
    }

    public function updateCategory(){
        $category = Category::findOrFail($this->category_id);
        $this->validate([
            'category_name'=>'required|unique:categories,name,'.$category->id
        ],[
            'category_name.required' => 'Category name field is required.',
            'category_name.unique' => 'Category name is already exists.'
        ]);

        // store
        $category->name = $this->category_name;
        $category->parent = $this->parent;
        $category->slug = null;
        $updated = $category->save();
        if($updated){
            $this->hideCategoryModalForm();
            $this->dispatch('showSweetAlert',['type'=>'success','message'=>'Category has been updated Successfully.']);
        }else{
            $this->dispatch('showSweetAlert',['type'=>'error','message'=>'Something went wrong.']);
        }

    }

    public function updateCategoryOrdering($positions){
        // dd($positions);
        foreach($positions as $position){
            $index = $position[0];
            $new_position = $position[1];
            Category::where('id',$index)->update([
                'ordering' => $new_position
            ]);
            $this->dispatch('showSweetAlert',['type'=>'success','message'=>'Categories ordering have been updated successfully.']);
        }
    }

    public function deleteCategory($id){
        $this->dispatch('deleteCategory',['id'=>$id]);
    } 
    
    public function deleteCategoryAction($id){
        $category = Category::findOrFail($id);
        // check if this category has related post(s)

        //Delete Category
        $delete = $category->delete();

        if($delete){
            $this->dispatch('showSweetAlert',['type'=>'success','message'=>'Category has been deleted successfully.']);
        }else{
            $this->dispatch('showSweetAlert',['type'=>'error','message'=>'Something went wrong.']);
        }
    }

    public function render()
    {
        return view('livewire.admin.categories',[
            'pcategories' => ParentCategory::orderBy('ordering','asc')->get(),
            'categories' => Category::orderBy('ordering','asc')->get()
        ]);
    }
}
