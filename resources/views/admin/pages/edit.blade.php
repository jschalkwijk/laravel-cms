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
                @if (isset($page->page_id))
                    <?php $action = '/admin/pages/update/'.$page->page_id.'/'.$page->title; $method = 'PATCH'; ?>
                @else
                    <?php $action = '/admin/pages/add'; $method = 'PUT'; ?>
                @endif
                <form id="addpost-form" class="large" action="{{$action}}" method="page">
                    {{ method_field($method) }}
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$page->page_id}}"/>
                    <input type="text" name="title" placeholder="Title" value="{{ $page->title }}"><br />
                    <input type="text" name="description" placeholder="page Description (max 160 characters)" value="{{$page->description}}"/><br />
                    <label for="select">Category</label>
                    <textarea type="text" name="content" placeholder="Content">{{ $page->content }}</textarea><br />

                    <p>Are you sure you want to edit the following page?</p>
                    <input type="radio" name="confirm" value="true" /> Yes
                    <input type="radio" name="confirm" value="false" checked="checked" /> No <br />
                    <button type="submit" name="submit">Submit</button>
                </form>
                <div id="return" class="container medium left">

                    {{--@require('blocks/include-files-tinymce.php')--}}

                </div>
            </div>
        </div>
    </div>
@stop
