@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? pageTitle: 'Page Title Here')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Settings</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Settings
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="pd-20 card-box mb-4">
    @livewire('admin.settings')
</div>
@endsection

@push('script')
<script>
    // Logo preview and ajax
        $('input[type="file"][name="site_logo"]').on('change', function () {
            const file = this.files[0];
            const preview = $('#preview_site_logo');
            const allowedExtensions = ['png', 'jpg'];

            if (file) {
                const fileExtension = file.name.split('.').pop().toLowerCase();

                if (!allowedExtensions.includes(fileExtension)) {
                    alert('Invalid file type! Please upload a PNG or JPG file.');
                    $(this).val(''); // Clear the input
                    preview.hide(); // Hide the preview
                    return;
                }

                const reader = new FileReader();

                reader.onload = function (e) {
                    preview.attr('src', e.target.result).show(); // Set the image and show the preview
                };

                reader.readAsDataURL(file);
            } else {
                preview.hide(); // Hide the preview if no file is selected
            }
        });
    
        $('#updateLogoForm').submit(function(e){
            e.preventDefault();
            var form = this;
            var inputVal = $(form).find('input[type="file"]').val();
            var errorElement = $(form).find('span.text-danger');
            errorElement.text('');

            if(inputVal.length > 0){
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){},
                    success:function(data){
                        if(data.status == 1){
                            $(form)[0].reset();
                            swal.fire({
                                title: data.message,
                                icon: "success",
                            });
                        }else{
                            
                            swal.fire({
                                title: data.message,
                                icon: "error",
                            });
                        }
                        
                        $('img.site_logo').each(function(){
                            $(this).attr('src','/'+data.image_path)
                        });
                        

                    }
                });
            }else{
                errorElement.text('Please, Select an image file');
            }
        });

    // Favicon preview and ajax
    $('input[type="file"][name="site_favicon"]').on('change', function () {
        const file = this.files[0];
        const preview = $('#preview_site_favicon');
        const allowedExtensions = ['png', 'jpg'];

        if (file) {
            const fileExtension = file.name.split('.').pop().toLowerCase();

            if (!allowedExtensions.includes(fileExtension)) {
                alert('Invalid file type! Please upload a PNG or JPG file.');
                $(this).val(''); // Clear the input
                preview.hide(); // Hide the preview
                return;
            }

            const reader = new FileReader();

            reader.onload = function (e) {
                preview.attr('src', e.target.result).show(); // Set the image and show the preview
            };

            reader.readAsDataURL(file);
        } else {
            preview.hide(); // Hide the preview if no file is selected
        }
    });

    $('#updateFaviconForm').submit(function(e){
            e.preventDefault();
            var form = this;
            var inputVal = $(form).find('input[type="file"]').val();
            var errorElement = $(form).find('span.text-danger');
            errorElement.text('');

            if(inputVal.length > 0){
                $.ajax({
                    url:$(form).attr('action'),
                    method:$(form).attr('method'),
                    data:new FormData(form),
                    processData:false,
                    dataType:'json',
                    contentType:false,
                    beforeSend:function(){},
                    success:function(data){
                        if(data.status == 1){
                            $(form)[0].reset();
                            var linkElement = document.querySelector('link[rel="icon"]');
                            linkElement.href='/'+data.image_path;
                            swal.fire({
                                title: data.message,
                                icon: "success",
                            });
                        }else{
                            
                            swal.fire({
                                title: data.message,
                                icon: "error",
                            });
                        }
                        
                        $('img.site_favicon').each(function(){
                            $(this).attr('src','/'+data.image_path)
                        });
                        

                    }
                });
            }else{
                errorElement.text('Please, Select an image file');
            }
        });

</script>

@endpush