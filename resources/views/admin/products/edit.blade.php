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
                @if (isset($product->product_id))
                    <?php $action = '/admin/products/'.$product->product_id; $method = 'PATCH'; ?>
                @else
                    <?php $action = '/admin/products/add'; $method = 'PUT'; ?>
                @endif
                <form id="addpost-form" class="large" action="{{$action}}" method="post">
                    {{ method_field($method) }}
                    {{ csrf_field() }}
                    <input type="text" name="name" placeholder="Name" value="{{ old('name',$product->name)}}"><br />
                    <input type="number" name="price" placeholder="Price" pattern="(^\d+(\.|\,)\d{2}$)" min="0" value="{{ old('price',$product->price) }}">
                    <input type="number" name="quantity" placeholder="Quantity between 0 and 1000" min="0" max="1000" value="{{ old('quantity',$product->quantity) }}"/>
                    <label for="select">Category</label>
                    <select id="categories" name="category_id">
                        <option value="None">None</option>
                        @foreach($categories as $category)
                            @if($product->category['category_id'] == $category->category_id)
                                <option value="{{$category->category_id}}" selected>{{$category->title}}</option>
                            @else
                                <option value="{{$category->category_id}}">{{$category->title}}</option>
                            @endif
                        @endforeach
                    </select>
                    <input type="text" name="category" placeholder="Category"/><br />
                    <input type="hidden" name="cat_type" value="product"/><br />
                    <textarea type="text" name="description" placeholder="Description">{{ old('description',$product->description) }}</textarea><br />
                    <p>Are you sure you want to edit the following product?</p>
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