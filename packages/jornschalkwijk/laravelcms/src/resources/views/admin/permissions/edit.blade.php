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
                <form action="{{route("permissions.update")}}" method="post">
                    {{method_field('POST')}}
                    {{ csrf_field() }}
                    <input type="text" name="name" placeholder="Permissions Name" value="{{ empty(old('name')) ? $permission->name : old('name')}}"/>
                    @include('JornSchalkwijk\LaravelCMS::admin.roles.partials.table-form-input')
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@stop