@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-sm-3 offset-md-3 offset-lg-3">
            <form action="{{route("roles.action")}}" method="post">
                {{ csrf_field() }}
                <table class="table table-sm table-striped">
                    <thead class="thead-default">
                    <tr>
                        <td>#</td><td>Role</td><td>Edit</td><td>Del</td>
                    </tr>
                    </thead>
                    @foreach($roles as $single)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td><a href="{{route('roles.show',$single->role_id)}}">{{ $single->name }}</a></td>
                            @include('JornSchalkwijk\LaravelCMS::admin.partials.single-action')
                        </tr>
                    @endforeach
                </table>
                @include('JornSchalkwijk\LaravelCMS::admin.partials.actions')
            </form>
        </div>
    </div>
</div>
@stop