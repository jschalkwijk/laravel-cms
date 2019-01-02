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
            <div id="errors" class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <form method="post" action="{{route('posts.update',$post->post_id)}}">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <input type="hidden" name="id" value="{{$post->post_id}}" class="form-control"/>
                        <input type="text" name="title" placeholder="Title" value="{{ old('title',$post->title)}}" class="form-control"/><br />
                        <input type="text" name="description" placeholder="Post Description (max 160 characters)" value="{{old('description',$post->description)}}" class="form-control"/><br />
                    </div>
                    <div class="form-group row">
                        <label for="categories" class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-10">
                            <select id="categories" name="category_id" class="form-control">
                                <option value="None">None</option>
                                @foreach($categories as $category)
                                    @if($category->category_id == $post->category_id)
                                        <option value="{{$category->category_id}}" selected>{{$category->title}}</option>
                                    @else
                                        <option value="{{$category->category_id}}">{{$category->title}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <input type="text" name="category" placeholder="Create Category" class="form-control"/><br />
                        <input type="hidden" name="cat_type" value="post"/><br />
                    </div>
                    <div class="form-group row">
                        <label for="tags" class="col-sm-2 col-form-label">Tags</label>
                        <div class="col-sm-10">
                        <select id="tags" class="prettyTags" name="tag_ids[]" multiple size="3" style="display: none;">
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
                        </div>

                        <input type="text" name="tag" placeholder="Create Tag('s), for multiple tags seperate with a dash ( - )" class="form-control"/><br />
                        <input type="hidden" name="tag_type" value="post"/><br />
                    </div>
                    <textarea type="text" name="content" placeholder="Content" class="form-control">{{ old('content',$post->content) }}</textarea><br />


                    <p>Are you sure you want to edit the following post?</p>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="yes" name="confirm" value="true">
                        <label class="form-check-label" for="yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="no" name="confirm" value="false" checked="checked">
                        <label class="form-check-label" for="no">No</label>
                    </div>

                    {{--<input type="radio" name="confirm" value="true" class="form-control"/> Yes--}}
                    {{--<input type="radio" name="confirm" value="false" checked="checked" class="form-control"/> No--}}
                    <button type="submit" name="submit" class="form-control">Submit</button>
                </form>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                @include('JornSchalkwijk\LaravelCMS::admin.uploads.file-manager.index')
            </div>
        </div>
    </div>
    @include('JornSchalkwijk\LaravelCMS::admin.partials.prettyTags')
@stop

