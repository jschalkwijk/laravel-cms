@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-sm-3 offset-md-3 offset-lg-3">
                {{ csrf_field() }}
                <form action="{{route("permissions.action")}}" method="post">
                    <table>
                        <thead>
                        <tr>
                            <td>#</td><td>Permissions</td><td>Edit</td><td>Del</td>
                        </tr>
                        </thead>
                        @foreach($permissions as $single)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $single->name }}</td>
                                @include('admin.partials.single-actions')
                            </tr>
                        @endforeach
                    </table>
                    @include('admin.partials.actions')
                </form>
            </div>
        </div>
    </div>
@stop