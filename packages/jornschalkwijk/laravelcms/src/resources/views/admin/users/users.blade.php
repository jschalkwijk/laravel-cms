@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-lg-6 offset-xs-3 offset-sm-3 offset-lg-3">
                <form class="form-inline" method="GET" action="{{route('users.index')}}">
                    <input class="form-control mr-sm-2" type="search" name='search' placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                @role('admin')
                    <a href="/admin/users/new" class="link-btn">Add User</a>
                @endrole
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                <div class="center">
                @include('JornSchalkwijk\LaravelCMS::admin.users.users-table')
            </div>
        </div>
    </div>
@stop