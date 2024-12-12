@extends('back.layout.pages-layout')
@section('pageTitle', isset($pageTitle) ? pageTitle: 'Page Title Here')
@section('content')
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

    <div class="row">
        <div class="col-md-12 col-sm-12 mt-2">
            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="h4 text-blue">Parent Categories</h4>
                </div>
                <div class="pull-right">
                    <a href="" class="btn btn-primary">Add P. Category</a>
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
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>P. cat 1</td>
                            <td>4</td>
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
                    </tbody>
                </table>    
            </div>
        </div>
        
        <div class="col-md-12 col-sm-12 mt-2">
            <div class="clearfix">
                <div class="pull-left">
                    <h4 class="h4 text-blue">Categories</h4>
                </div>
                <div class="pull-right">
                    <a href="" class="btn btn-primary">Add Category</a>
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
                        <tr>
                            <td>1</td>
                            <td>P. cat 1</td>
                            <td>Any</td>
                            <td>4</td>
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
                    </tbody>
                </table>    
            </div>
        </div>
    </div>
    
</div>
@endsection