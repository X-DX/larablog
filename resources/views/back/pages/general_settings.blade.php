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
    $(document).ready(function() {
        $('input[type="file"][name="site_logo"]').on('change', function(event) {
            const fileInput = $(this); // Get the file input element
            const preview = $('#preview_site_logo'); // Get the preview image element
            const file = event.target.files[0]; // Get the selected file

            // Clear previous preview if any
            preview.attr('src', '');

            if (file) {
                // Validate file type
                const validExtensions = ['image/png', 'image/jpeg'];
                if (!validExtensions.includes(file.type)) {
                    alert('Only PNG and JPG files are allowed.');
                    fileInput.val(''); // Reset the input value
                    return;
                }

                // Validate file size (optional, e.g., max 2MB)
                const maxSize = 2 * 1024 * 1024; // 2MB
                if (file.size > maxSize) {
                    alert('File size must not exceed 2MB.');
                    fileInput.val(''); // Reset the input value
                    return;
                }

                // Create image preview
                const fileReader = new FileReader();
                fileReader.onload = function(e) {
                    preview.attr('src', e.target.result); // Set the image preview
                };
                fileReader.readAsDataURL(file); // Read the file
            }
        });
    });
</script>

@endpush