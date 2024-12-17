@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? pageTitle: 'Page Title Here')
@section('content')
    @livewire('admin.Categories')
@endsection
@push('script')
    <script>
        window.addEventListener('showParentCategoryModalForm', function(){
            $('#pcategory_modal').modal('show');
        });

        window.addEventListener('hideParentCategoryModalForm', function(){
            $('#pcategory_modal').modal('hide');
        });

        window.addEventListener('showCategoryModalForm', function(){
            $('#category_modal').modal('show');
        });

        window.addEventListener('hideCategoryModalForm', function(){
            $('#category_modal').modal('hide');
        });

        $('table tbody#sortable_parent_categories').sortable({
            cursor:"move",
            update: function(event, ui){
                $(this).children().each(function(index){
                    if( $(this).attr('data-ordering') != (index + 1) ){
                        $(this).attr('data-ordering', (index+1)).addClass('updated');
                    }
                });
                var positions = [];
                $('.updated').each(function(){
                    positions.push([$(this).attr('data-index'),$(this).attr('data-ordering')]);
                    $(this).removeClass('updated');
                });
                // alert(positions);
                Livewire.dispatch('updateParentCategoryOrdering',[positions]);
            }
        });

        window.addEventListener('deleteParentCategory', function(event) {
        var id = event.detail[0].id;

        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this parent category.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            customClass: {
                popup: 'font-size-1rem', // Optional: Define your custom CSS class
            },
            }).then((result) => {
                if (result.isConfirmed) {
                    // Trigger the Livewire action if the user confirms
                    Livewire.dispatch('deleteParentCategoryAction', [id]);

                    // Optionally show a confirmation message
                    Swal.fire(
                        'Deleted!',
                        'The parent category has been deleted.',
                        'success'
                    );
                }
            });
        });

        $('table tbody#sortable_categories').sortable({
            cursor:"move",
            update: function(event, ui){
                $(this).children().each(function(index){
                    if( $(this).attr('data-ordering') != (index + 1) ){
                        $(this).attr('data-ordering', (index+1)).addClass('updated');
                    }
                });
                var positions = [];
                $('.updated').each(function(){
                    positions.push([$(this).attr('data-index'),$(this).attr('data-ordering')]);
                    $(this).removeClass('updated');
                });
                // alert(positions);
                Livewire.dispatch('updateCategoryOrdering',[positions]);
            }
        });

        window.addEventListener('deleteCategory', function(event) {
        var id = event.detail[0].id;

        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to delete this parent category.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel',
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            allowOutsideClick: false,
            customClass: {
                popup: 'font-size-1rem', // Optional: Define your custom CSS class
            },
            }).then((result) => {
                if (result.isConfirmed) {
                    // Trigger the Livewire action if the user confirms
                    Livewire.dispatch('deleteCategoryAction', [id]);

                    // Optionally show a confirmation message
                    Swal.fire(
                        'Deleted!',
                        'The parent category has been deleted.',
                        'success'
                    );
                }
            });
        });


    </script>
@endpush