@extends('admin.layout')
@section('content')
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <select id="gallery" name="gallery">
                @foreach($galleries as $gallery)
                    <option value="{{$gallery->gallery_id}}">{{$gallery->name}}</option>
                @endforeach
            </select>
        </div>
        <button id="add-gallery" name="add-gallery">Add Gallery</button>
    </div>
@stop