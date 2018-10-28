@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <script type="text/javascript" src="{{ asset("/vendor/jornschalkwijk/LaravelCMS/assets/js/tinymce/tinymce/tinymce.min.js") }}"></script>
    <script type="text/javascript">
        tinymce.init({
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste",

            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
            paste_data_images: true,
            relative_urls :false,
            convert_urls: true
        });
    </script>
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
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <form id="addpost-form" action="{{route("pages.store")}}" method="post">
                    {{method_field('POST')}}
                    {{ csrf_field() }}
                    <input type="text" name="title" placeholder="Title" value="{{ old('title')}}"><br />
                    <input type="text" name="description" placeholder="Page Description (max 160 characters)" value="{{old('description')}}"/><br />
                    <input type="text" name="slug" placeholder="Custom Link" value="{{old('slug')}}"/><br />

                    <textarea name="content" placeholder="Content">{{ old('content') }}</textarea><br />
                    <input type="text" name="template" placeholder="Custom Template" value="{{old('template')}}">
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                @include('JornSchalkwijk\LaravelCMS::admin.uploads.partials.search-add-uploads')
            </div>
        </div>
    </div>
@stop