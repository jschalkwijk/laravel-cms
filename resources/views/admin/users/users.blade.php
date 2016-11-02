@extends('admin.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <a href="/admin/users/new" class="link-btn">Add User</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <table class="backend-table title">
                    <tr><th>Name</th><th>E-mail</th><th>Rights</th><th>Date/Time</th><th>Edit</th><th>View</th></tr>
                    @each('admin.content.user-table',$users,'single')
                </table>
            </div>
        </div>
    </div>
@stop