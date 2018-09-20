@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                <div class="center">
                    <form class="dropzone"
                          id="dropzone"
                          enctype="multipart/form-data" method="post" action="{{ route('uploads.store') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="MAX_FILE_SIZE" value="43500000" />
                    <label for="files[]">Choose File(max size: 3.5 MB): </label><br />
                    <input type="file" name="files[]" multiple/><br />
                    <input type="text" name="name" placeholder="New Folder" maxlength="60"/>
                    {{--<input type="text" name="new_album_name" placeholder="Create New Sub Folder" maxlength="60"/>--}}
                    <button type="submit" name="submit">Add File('s)</button>
                </form></div>
            </div>
        </div>
    </div>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
            @include('admin.uploads.folders.folders-table')
        </div>
    </div>
    @if(!$files->isEmpty())
    <div class="row">
        <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
            @include('admin.uploads.uploads-table')
        </div>
    </div>
    @endif
</div>
    @push('scripts')
    <script src="{{asset("js/dropzone/min/dropzone.min.js")}}"></script>
    @endpush
    @push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset("js/dropzone/min/dropzone.min.css")}}"/>
    @endpush
@stop