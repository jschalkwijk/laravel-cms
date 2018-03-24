@extends('admin.layout')
@section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                @role('admin')
                    <a href="/admin/users/new" class="link-btn">Add User</a>
                @endrole
            </div>
        </div>homestead
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                <div class="center">
                @include('admin.content.user-table')
            </div>
        </div>
    </div>
@stop