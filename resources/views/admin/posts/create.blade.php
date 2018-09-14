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
                <form method="post" action="{{route('posts.store')}}">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <input type="text" name="title" placeholder="Title" value="{{ old('title')}}" class="form-control"/><br />
                        <input type="text" name="description" placeholder="Post Description (max 160 characters)" value="{{old('description')}}" class="form-control"/><br />
                    </div>
                    <div class="form-group row">
                        <label for="categories" class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-10">
                            <select id="categories" name="category_id" class="form-control">
                                <option value="None">None</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->category_id}}">{{$category->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" name="category" placeholder="Create Category" class="form-control"/><br />
                        <input type="hidden" name="cat_type" value="post"/><br />
                    </div>
                    <div class="form-group row">
                        <label for="tags" class="col-sm-2 col-form-label">Tags</label>
                        <div class="col-sm-10">
                            <select id="tags" name="tag_ids[]" multiple size="3" class="form-control">
                                <option value="None">None</option>
                                @foreach($tags as $tag)
                                    <option value="{{$tag->tag_id}}">{{$tag->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        <input type="text" name="tag" placeholder="Create Tag('s), for multiple tags seperate with a dash ( - )" class="form-control"/><br />
                        <input type="hidden" name="tag_type" value="post"/><br />
                    </div>
                    <textarea type="text" name="content" placeholder="Content" class="form-control">{{ old('content') }}</textarea><br />

                    <button type="submit" name="submit" class="form-control">Submit</button>
                </form>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                @include('admin.uploads.partials.search-add-uploads')
            </div>
        </div>
    </div>
@stop