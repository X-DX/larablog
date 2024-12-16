<div>
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Categories</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Categories
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="page-header">
        <div class="row">
            <div class="col-md-12 col-sm-12 mt-2">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="h4 text-blue">Parent Categories</h4>
                    </div>
                    <div class="pull-right">
                        <a href="javascript:;" wire:click="addParentCategory()" class="btn btn-primary">Add P. Category</a>
                    </div>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-borderless table-striped table-sm">
                        <thead class="bg-secondary text-white">
                            <th>#</th>
                            <th>Name</th>
                            <th>N. of Categories</th>
                            <th>Action</th>
                        </thead>
                        <tbody id="sortable_parent_categories">
                            @forelse ($pcategories as $item)
                                
                            <tr data-index="{{ $item->id }}" data-ordering="{{ $item->ordering }}">
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->children->count() }}</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="javascript:;" wire:click="editParentCategory({{ $item->id }})" class="text-primary mx-2">
                                            <i class="dw dw-edit2"></i>
                                        </a>
                                        <a href="javascript:;" wire:click="deleteParentCategory({{ $item->id }})" class="text-danger mx-2">
                                            <i class="dw dw-delete-3"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <span class="text-danger">No Item Found!</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>
    
    <div class="page-header">
        <div class="row">       
            <div class="col-md-12 col-sm-12 mt-2">
                <div class="clearfix">
                    <div class="pull-left">
                        <h4 class="h4 text-blue">Categories</h4>
                    </div>
                    <div class="pull-right">
                        <a href="javascript:;" wire:click="addCategory()" class="btn btn-primary">Add Category</a>
                    </div>
                </div>
                <div class="table-responsive mt-2">
                    <table class="table table-borderless table-striped table-sm">
                        <thead class="bg-secondary text-white">
                            <th>#</th>
                            <th>Name</th>
                            <th>Parent Category</th>
                            <th>N. of posts</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @forelse ($categories as $item)                              
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ !is_null($item->parent_category) ? $item->parent_category->name: ' - ' }}</td>
                                <td>-</td>
                                <td>
                                    <div class="table-actions">
                                        <a href="" class="text-primary mx-2">
                                            <i class="dw dw-edit2"></i>
                                        </a>
                                        <a href="" class="text-danger mx-2">
                                            <i class="dw dw-delete-3"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td class="colspan-5">
                                        <span class="text-danger">
                                            No Item Found!
                                        </span>
                                    </td>
                                </tr>    
                            @endforelse
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>   
    

    {{--  Modals --}}
    <div wire:ignore.self class="modal fade" id="pcategory_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" wire:submit="{{ $isUpdateParentCategoryMode ? 'updateParentCategory()' : 'createParentCategory()' }}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ $isUpdateParentCategoryMode ? 'Update P.     Category' : 'Add Category' }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    @if($isUpdateParentCategoryMode)
                        <input type="hidden" wire:model="pcategory_id">
                    @endif
                    <div class="form-group">
                        <label for=""><b>Parent Category Name</b></label>
                        <input type="text" class="form-control" wire:model="pcategory_name" placeholder="Enter parent category name here...">
                    </div>
                    @error('pcategory_name')
                        <span class="text-danger ml-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ $isUpdateParentCategoryMode ? 'Save change' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>


    <div wire:ignore.self class="modal fade" id="category_modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-dialog-centered">
            <form class="modal-content" wire:submit="{{ $isUpdateCategoryMode ? 'updateCategory()' : 'createCategory()' }}">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ $isUpdateCategoryMode ? 'Update Category' : 'Add Category' }}
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                        ×
                    </button>
                </div>
                <div class="modal-body">
                    @if($isUpdateCategoryMode)
                        <input type="hidden" wire:model="category_id">
                    @endif
                    <div class="form-group">
                        <label for=""><b>Parent Category</b>:</label>
                        <select wire:model="parent" class="custom-select">
                            <option value="0">Uncategorized</option>
                            @foreach ($pcategories as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>         
                            @endforeach
                        </select>
                        @error('parent')
                            <span class="text-danger ml-1">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for=""><b>Category Name</b></label>
                        <input type="text" class="form-control" wire:model="category_name" placeholder="Enter category name here...">
                    </div>
                    @error('category_name')
                        <span class="text-danger ml-1">{{ $message }}</span>
                    @enderror
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        {{ $isUpdateCategoryMode ? 'Save change' : 'Create' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
