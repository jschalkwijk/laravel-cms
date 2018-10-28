@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-sm-3 offset-md-3 offset-lg-3">
                <h2 class="text-center">{{ $permission->name }}</h2>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-sm-3 offset-md-3 offset-lg-3">
                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center" colspan="6">Belongs to the following Roles</th>
                    </thead>
                    <tbody>
                    <tr>
                        @php ($i = 1)
                        @foreach($permission->roles as $role)
                            <td><a href="{{route('roles.show',$role->role_id)}}"> {{ $role->name }}</a></td>
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
                        <th class="text-center" colspan="6">Users holding this Permissions</th>
                    </thead>
                    <tbody>
                    <tr>
                        @php ($i = 1)
                        @foreach($permission->users as $user){ }}
                            <td><a href="{{ route('users.show',$user->user_id) }}">{{ $user->firstName()." ".$user->lastName }}</a> </td>
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