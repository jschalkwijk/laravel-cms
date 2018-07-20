@extends('admin.layout')
@section('content')
    <div class="container">
        @if(isset($posts))
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                    <h2>Posts</h2>
                    <div class="center">
                        @include('admin.posts.posts-table')
                    </div>
                </div>
            </div>
        @endif
        @if(isset($categories))
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                        <h2>Categories</h2>
                        <div class="center">
                            @include('admin.categories.categories-table')
                        </div>
                    </div>
                </div>
            @endif
        @if(isset($users))
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                    <h2>Users</h2>
                    <div class="center">
                        @include('admin.users.users-table')
                    </div>
                </div>
            </div>
        @endif
        @if(isset($folders))
                <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                    <h2>Folders</h2>
                    <div class="center">
                        @include('admin.uploads.folders.folders-table')
                    </div>
                </div>
            </div>
        @endif
        @if(isset($files))
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                    <h2>Files</h2>
                    <div class="center">
                        @include('admin.uploads.uploads-table')
                    </div>
                </div>
            </div>
        @endif
    </div>
@stop