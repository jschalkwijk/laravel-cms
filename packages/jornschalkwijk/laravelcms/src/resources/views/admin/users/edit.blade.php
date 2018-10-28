@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                @if (count($errors))
                    @foreach($errors->all() as $error)
                        <div class="alert alert-warning">{{ $error }}</div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-sm-3 offset-md-3 offset-lg-3">
                <form action="{{route("users.update",$user->user_id)}}" method="post">
                    {{method_field('PATCH')}}
                    {{ csrf_field() }}
                    <input type="text" class="form-control" name="username" placeholder="Username" value="{{ empty(old('username')) ? $user->username : old('username')}}"/><br />
                    <input type="password" class="form-control" name="password" placeholder="New Password"/><br />
                    <input type="password" class="form-control" name="password_confirmation" placeholder="New Password Again"/><br />
                    <input type="text" class="form-control" name="first_name" placeholder="First name" value="{{ empty(old('first_name'))? $user->fisrt_name: old('first_name')}}"/> <br />
                    <input type="text" class="form-control" name="last_name" placeholder="Last name" value="{{ empty(old('last_name'))? $user->last_name: old('last_name')}}"/> <br />
                    <input type="text" class="form-control" name="email" placeholder="Email" value="{{ empty(old('email'))? $user->email: old('email')}}"/> <br />
                    <input type="text" class="form-control" name="function" placeholder="Function" value="{{ empty(old('function'))? $user->function: old('function')}}"/> <br />
                    @include('JornSchalkwijk\LaravelCMS::admin.roles.partials.table-form-input')
                    @include('JornSchalkwijk\LaravelCMS::admin.permissions.partials.table-form-input')
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@stop