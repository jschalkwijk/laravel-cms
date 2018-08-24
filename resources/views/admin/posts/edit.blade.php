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
    <div class="container-fluid">
        <div class="row">
            <div id="errors" class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                @if (count($errors))
                    @foreach($errors->all() as $error)
                        <div class="alert alert-warning">{{ $error }}</div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <form id="addpost-form" class="large" method="post" action="{{route('posts.update',$post->post_id)}}">
                    {{ method_field('PATCH') }}
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
                    <input type="radio" name="confirm" value="false" checked="checked" /> No
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                {{-- Searching uploads--}}
                @include('admin.uploads.partials.search-add-uploads')
                {{-- Creating ,showing and adding uploads to a gallery--}}
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="row">
                            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                <select id="gallery" name="gallery">
                                    <option value="None">None</option>
                                    @foreach($galleries as $gallery)
                                        <option value="{{$gallery->gallery_id}}">{{$gallery->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button id="add-gallery" name="add-gallery">Add Gallery</button>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <form>
                                    {{ csrf_field() }}
                                    <input type="text" id="name" name="name" placeholder="name">
                                    <button id="create-gallery" name="create-gallery">Create Gallery</button>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button id="add-to-gallery" name="add-to-gallery">Add To Gallery</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div id="selected-gallery" class="col-xs-6 col-sm-6 col-md-6 col-lg-6">

                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

