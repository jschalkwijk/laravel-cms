@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <script type="text/javascript" src="{{ asset("/vendor/jornschalkwijk/LaravelCMS/assets/js/tinymce/tinymce/tinymce.min.js") }}"></script>
    <script type="text/javascript">
        tinymce.init({
            setup: function (editor) {
                editor.addButton('filemanager', {
                    text: 'File Manager',
                    icon: 'image',
                    id: 'file_manager',
                    classes: 'my_popup_open',
                });
            },
            selector: "textarea",
            plugins: [
                "advlist autolink lists link image charmap print preview anchor",
                "searchreplace visualblocks code fullscreen",
                "insertdatetime media table contextmenu paste",

            ],
            toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link filemanager",
            paste_data_images: true,
            relative_urls :false,
            convert_urls: true,

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
                <form action="{{route('products.store')}}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="name" class="col-sm-2 col-form-label">Name</label>
                        <div class="col-sm-10"><input type="text" name="name" placeholder="Name" value="{{ old('name')}}" class="form-control"></div>
                        <label for="price" class="col-sm-2 col-form-label">Price</label>
                        <div class="col-sm-10"><input type="number" name="price" placeholder="Price" pattern="(^\d+(\.|\,)\d{2}$)" min="0" value="{{ old('price')}}" class="form-control"></div>
                        <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                        <div class="col-sm-10"><input type="number" name="quantity" placeholder="Between 0 and 1000" min="0" max="1000" value="{{ old('quantity') }}" class="form-control"/></div>
                        <label for="tax_percentage" class="col-sm-2 col-form-label">Tax %</label>
                        <div class="col-sm-10"><input type="number" name="tax_percentage" placeholder="Between 0 and 100" min="0" max="100" value="{{ old('tax_percentage') }}" class="form-control"/></div>
                        <label for="discount_percentage" class="col-sm-2 col-form-label">Discount %</label>
                        <div class="col-sm-10"><input type="number" name="discount_percentage" placeholder="Between 0 and 100" min="0" max="1000" value="{{ old('discount_percentage') }}" class="form-control"/></div>

                    </div>
                    <div class="form-group row">
                        <label for="categories" class="col-sm-2 col-form-label">Category</label>
                        <div class="col-sm-10">
                            <select id="categories" name="category_id" class="form-control">
                                <option value="None">None</option>
                                @foreach($categories as $category)
                                    @if($category->category_id == old('category_id'))
                                        <option value="{{$category->category_id}}" selected>{{$category->title}}</option>
                                    @else
                                        <option value="{{$category->category_id}}">{{$category->title}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <input type="text" name="category" placeholder="Create Category" class="form-control"/><br />
                        <input type="hidden" name="cat_type" value="product"/><br />
                    </div>
                    <div class="form-group row">
                        <label for="tags" class="col-sm-2 col-form-label">Tags</label>
                        <div class="col-sm-10">
                            <select id="tags" class="prettyTags" name="tag_ids[]" multiple size="3" style="display: none;">
                                @foreach($tags as $tag)
                                    @if(in_array($tag->tag_id,old('tags',[]))) )
                                    <option value="{{$tag->tag_id}}" selected>{{$tag->title}}</option>
                                    @else
                                        <option value="{{$tag->tag_id}}">{{$tag->title}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <input type="hidden" name="tag_type" value="product"/><br />
                    </div>
                    <div class="form-group">
                        <textarea type="text" name="description" placeholder="Description" class="form-control">{{ old('description') }}</textarea><br />
                        <p>Are you sure you want to edit the following product?</p>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="yes" name="confirm" value="true">
                        <label class="form-check-label" for="yes">Yes</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" id="no" name="confirm" value="false" checked="checked">
                        <label class="form-check-label" for="no">No</label>
                    </div>
                    <button type="submit" name="submit">Submit</button>

                </form>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                @include('JornSchalkwijk\LaravelCMS::admin.uploads.file-manager.index')
            </div>
        </div>
    </div>
    @include('JornSchalkwijk\LaravelCMS::admin.partials.prettyTags')
@stop