@extends('layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                <form id="check-folders" method="post" action="/admin/uploads/action">
                    {{ csrf_field() }}
                    <table class="table table-sm table-striped">
                        <thead class="thead-default">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Size(MB)</th>
                            <th>
                                <button type="button" id="check-all"><img class="glyph-small" src="/images/check.png"/></button>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($folders as $folder)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><a href="/files/{{ $folder->id() }}/{{ $folder->name }}">{{ $folder->name }}</a></td>
                                <td>Size</td>
                                <td><input class="checkbox" type="checkbox" name="checkbox[]" value="{{ $folder->id() }}"/></td>
                                <td><input type="hidden" name="name" value="{{ $folder->name }}"/></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <button type="submit" name="delete-albums" id="delete-albums">Delete Albums</button>
                </form>
            </div>
        </div>
    </div>
@stop