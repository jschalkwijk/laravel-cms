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
                <?php $action = '/admin/posts';?>
                <form id="addpost-form" class="large" action="{{$action}}" method="post">
                    {{ csrf_field() }}
                    <input type="text" name="title" placeholder="Title" value="{{ old('title')}}"><br />
                    <input type="text" name="description" placeholder="Post Description (max 160 characters)" value="{{old('description')}}"/><br />
                    <label for="select">Category</label>
                    <select id="categories" name="category_ids[]" multiple size="3">
                        <option value="None">None</option>
                        @foreach($categories as $category)
                            <option value="{{$category->category_id}}">{{$category->title}}</option>
                        @endforeach
                    </select>

                    <label for="select">Tags</label>
                    <select id="categories" name="tag_ids[]" multiple size="3">
                        <option value="None">None</option>
                        @foreach($tags as $tag)
                            <option value="{{$tag->tag_id}}">{{$tag->title}}</option>
                        @endforeach
                    </select>

                    <input type="text" name="category" placeholder="Category"/><br />
                    <input type="hidden" name="cat_type" value="product"/><br />

                    <input type="text" name="tag" placeholder="Tag('s) for multiple tags seperate with a dash ( - )"/><br />
                    <input type="hidden" name="tag_type" value="product"/><br />

                    <textarea type="text" name="content" placeholder="Content">{{ old('content') }}</textarea><br />
                    <button type="submit" name="submit">Submit</button>
                </form>
                <div id="return" class="container medium left">

                    {{--@require('blocks/include-files-tinymce.php')--}}

                </div>
            </div>
        </div>
    </div>
@stop