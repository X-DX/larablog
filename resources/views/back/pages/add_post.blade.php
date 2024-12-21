@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? pageTitle: 'Page Title Here')
@section('content')
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Add Post</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Add Post
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <a href="{{ route('admin.posts') }}"" class="btn btn-primary">View all posts</a>
        </div>
    </div>
</div>

<form action="{{ route('admin.create_post') }}" method="POST" autocomplete="off" enctype="multipart/form-data" id="addPostForm">
    @csrf
    <div class="row">
        <div class="col-md-9">
            <div class="card card-box mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><b>Title</b>:</label>
                        <input type="text" name="title" class="form-control" placeholder="Enter post title">
                        <span class="text-danger error-text title_error"></span>
                    </div>
                    <div class="form-group">
                        <label for=""><b>Content</b>:</label>
                        <textarea name="content" id="" cols="30" rows="10" class="form-control" placeholder="Enter post content here..."></textarea>
                        <span class="text-danger error-text content_error"></span>
                    </div>
                </div>
            </div>
            <div class="card card-box mb-2">
                <div class="card-header weight-500">SEO</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><b>Post meta keyword</b>: <small>(Separated by comma.)</small> </label>
                        <input type="text" name="meta_keyword" class="form-control" placeholder="Enter post meta keyword">
                    </div>
                    <div class="form-group">
                        <label for=""><b>Post meta description</b>:</label>
                        <textarea name="meta_description" id="" cols="30" rows="10" class="form-control" placeholder="Enter post meta description..."></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card card-box mb-2">
                <div class="card-body">
                    <div class="form-group">
                        <label for=""><b>Post Category</b>:</label>
                        <select name="category" id="" class="custom-select form-control">
                            {!! $categories_html !!}
                        </select>
                        <span class="text-danger error-text category_error"></span>
                    </div>  

                    <div class="form-group">
                        <label for=""><b>Post Featured image</b>:</label>
                        <input type="file" name="featured_image" class="form-control-file form-control" height="auto">
                        <span class="text-danger error-text featured_image_error"></span>
                    </div>

                    <div class="d-block mb-3" style="max-width: 250px;">
                        <img src="" alt="" class="img-thumbnail" id="featured_image_preview" data-ijabo-default-img="">
                    </div>

                    <div class="form-group">
                        <label for=""><b>Tags</b>:</label>
                        <input type="text" class="form-control" name="tags"> 
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for=""><b>Visibility</b></label>
                        <div class="custom-control custom-radio mb-5">
                            <input type="radio" name="visibility" id="customRadio1" class="custom-control-input" value="1" checked>
                            <label for="customRadio1" class="custom-control-label"><b>Public</b></label>
                        </div>
                        <div class="custom-control custom-radio mb-5">
                            <input type="radio" name="visibility" id="customRadio2" class="custom-control-input" value="0">
                            <label for="customRadio2" class="custom-control-label"><b>Private</b></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Create post</button>
    </div>
</form>
@endsection