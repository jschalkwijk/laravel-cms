@extends('admin.layout')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-lg-6 offset-xs-3 offset-sm-3 offset-lg-3">
               <div class="center button-block">
                   <a href="/admin/posts/create" class="btn btn-primary btn-sm visible-md-block">Add Post</a>
                   <a href="/admin/posts/deleted-posts" class="btn btn-primary visible-md-block">Deleted posts</a>
                   <a href="/admin/categories" class="btn btn-primary btn-sm visible-md-block">Categories</a>
                   <a href="/admin/categories/create" class="btn btn-primary btn-sm visible-md-block">Add Category</a>
               </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
               <div class="center">
                @include('admin.posts.posts-table')
               </div>
            </div>
        </div>
    </div>
@stop