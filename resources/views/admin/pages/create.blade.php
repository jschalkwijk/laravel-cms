@extends('admin.layout')
@section('content')
    <script type="text/javascript" src="{{ asset("/js/tinymce/tinymce/tinymce.min.js") }}"></script>
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
    <div class="containter">
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
                @if(isset($page))
                    @php
                        $action = route("pages.update",$page->page_id);
                        $method = 'PATCH';
                    @endphp
                @else
                    @php
                        $action = route("pages.store");
                        $method = 'PUT';
                    @endphp
                @endif
                <form action="{{$action}}" method="post">
                    {{method_field($method)}}
                    {{ csrf_field() }}
                    <input type="text" name="title" placeholder="Title" value="{{ empty(old('title')) ? $page->title : old('title')}}"><br />
                    <input type="text" name="description" placeholder="Page Description (max 160 characters)" value="{{ empty(old('description')) ? $page->description : old('description')}}"/><br />

                    <textarea type="text" name="content" placeholder="Content">{{ empty(old('content')) ? $page->content :old('content') }}</textarea><br />
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@stop