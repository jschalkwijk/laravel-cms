@extends('templates.default.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                <div class="center">
                    <form enctype="multipart/form-data" method="post" action="{{ route('folders.update',$folder->folder_id)}}">
                        {{ method_field('PATCH') }}
                        {{ csrf_field() }}
                        <input type="text" name="name" placeholder="New folder name"value="{{$folder->name}}" maxlength="60"/>
                        <button type="submit" name="submit">Edit Folder</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop