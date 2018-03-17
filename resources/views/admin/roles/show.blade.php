@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-sm-3 offset-md-3 offset-lg-3">
                <h2 class="text-center">{{ $role->name }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-sm-3 offset-md-3 offset-lg-3">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center" colspan="6">Has the following permissions</th>
                    </thead>
                    <tbody>
                    <tr>
                        @php ($i = 1)
                        @foreach($role->permissions as $permission)
                        <td><a href="{{route('permissions.show',$permission->permission_id)}}"> {{ $permission->name }}</a> </td>
                        @if ($i % 2 == 0)
                            </tr><tr>
                            @php($i++)
                        @endif
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-sm-3 offset-md-3 offset-lg-3">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center" colspan="6">Users holding this role</th>
                    </thead>
                    <tbody>
                    <tr>
                        @php ($i = 1)
                        @foreach($role->users as $user)
                            <td><a href="{{ route('users.show',$user->user_id )}}">{{ $user->first_name." ".$user->last_name }}</a> </td>
                            @if ($i % 2 == 0)
                                </tr><tr>
                                @php($i++)
                            @endif
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop