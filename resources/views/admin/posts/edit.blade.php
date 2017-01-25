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
                @if (isset($post->post_id))
                    <?php $action = '/admin/posts/'.$post->post_id; $method = 'PATCH'; ?>
                @else
                    <?php $action = '/admin/posts/add'; $method = 'PUT'; ?>
                @endif
                <form id="addpost-form" class="large" action="{{$action}}" method="post">
                    {{ method_field($method) }}
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$post->post_id}}"/>
                    <input type="text" name="title" placeholder="Title" value="{{ old('title',$post->title)}}"><br />
                    <input type="text" name="description" placeholder="Post Description (max 160 characters)" value="{{old('description',$post->description)}}"/><br />
                    <label for="select">Category</label>
                    <select id="categories" name="category_id">
                        <option value="None">None</option>
                        @foreach($categories as $category)
                            @if($category->category_id == $post->category_id)
                                    <option value="{{$category->category_id}}" selected>{{$category->title}}</option>
                            @else
                                <option value="{{$category->category_id}}">{{$category->title}}</option>
                            @endif
                        @endforeach
                    </select>
                    <select id="tags" name="tag_ids[]" multiple size="3">
                        <option value="None">None</option>
                        @foreach($post->tags as $tag)
                            <option value="{{$tag->tag_id}}" selected>{{$tag->title}}</option>
                        @endforeach
                        @foreach($tags as $tag)
                            @if(!in_array($tag->tag_id,$selectedTag) )
                                    <option value="{{$tag->tag_id}}">{{$tag->title}}</option>
                            @endif
                        @endforeach
                    </select>

                    <input type="text" name="category" placeholder="Category"/><br />
                    <input type="hidden" name="cat_type" value="post"/><br />

                    <input type="text" name="tag" placeholder="Tag('s) for multiple tags seperate with a dash ( - )"/><br />
                    <input type="hidden" name="tag_type" value="post"/><br />

                    <textarea type="text" name="content" placeholder="Content">{{ old('content',$post->content) }}</textarea><br />

                    <p>Are you sure you want to edit the following post?</p>
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