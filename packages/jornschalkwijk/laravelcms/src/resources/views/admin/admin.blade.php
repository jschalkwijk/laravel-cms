@extends('JornSchalkwijk\LaravelCMS::admin.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    You are logged in!
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
            <div class="center">
                @include('JornSchalkwijk\LaravelCMS::admin.posts.posts-table')
            </div>
        </div>
    </div>
    <a href="{{ route('comments.index') }}">Comments</a>
</div>
@endsection
