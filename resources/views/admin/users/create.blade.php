@extends('admin.layout')
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
                <form action="{{route("users.store")}}" method="post">
                    {{method_field('POST')}}
                    {{ csrf_field() }}
                    <input type="text" class="form-control" name="username" placeholder="Username" value="{{old('username')}}"/><br />
                    <input type="password" class="form-control" name="password" placeholder="New Password"/><br />
                    <input type="password" class="form-control" name="password_confirmation" placeholder="New Password Again"/><br />
                    <input type="text" class="form-control" name="first_name" placeholder="First name" value="{{ old('first_name')}}"/> <br />
                    <input type="text" class="form-control" name="last_name" placeholder="Last name" value="{{old('last_name')}}"/> <br />
                    <input type="text" class="form-control" name="email" placeholder="Email" value="{{old('email')}}"/> <br />
                    <input type="text" class="form-control" name="function" placeholder="Function" value="{{old('function')}}"/> <br />
                    @include('admin.roles.partials.table-form-input')
                    @include('admin.permissions.partials.table-form-input')
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@stop
