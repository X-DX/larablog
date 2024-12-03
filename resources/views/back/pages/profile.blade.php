@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? pageTitle: 'Page Title Here')
@section('content')
    
<div class="page-header">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="title">
                <h4>Profile</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Profile
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

@livewire('admin.profile')

@endsection
@push('script')
<script>
    $('input[type="file"][id="profilePictureFile"]').kropify({
        preview: 'image#profilePicturePreview',
        viewMode: 1,
        aspectRatio: 1,
        cancelButtonText: 'Cancel',
        resetButtonText: 'Reset',
        cropButtonText: 'Crop & update',
        processURL: '{{ route("admin.update_profile_picture") }}',
        maxSize: 2097152, // 2MB
        showLoader: true,
        animationClass: 'headShake', // headShake, bounceIn, pulse
        fileName: 'profilePictureFile',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(data) {
            if (data.status == 1) {
                Livewire.dispatch('updateTopUserInfo',[]);
                Livewire.dispatch('updateProfile',[]);
                swal.fire({
                    title: data.message,
                    icon: "success",
                }).then(() => {
                    // Refresh profile picture preview (optional)
                    $('#profilePicturePreview').attr('src', data.updatedImageURL);
                });
            }
        },
        errors: function(error, text) {
            swal.fire({
                title: "Error",
                text: text || "An unexpected error occurred.",
                icon: "error",
            });
        }
    });
</script>
@endpush
