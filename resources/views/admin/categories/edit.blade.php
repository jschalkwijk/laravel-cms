@extends('admin.layout')
@section('content')
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
                @if (isset($category->category_id))
                    <?php $action = '/admin/categories/'.$category->category_id; $method = 'PATCH'; ?>
                @endif

                <form id="addpost-form" class="container large left" action="{{$action}}" method="post">
                    {{ method_field($method) }}
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$category->post_id}}"/>
                    <input type="text" name="title" placeholder="Title" value="{{ $category->title }}"><br />
                    <input type="text" name="description" placeholder="Category Description (max 160 characters)" value="{{$category->description}}"/><br />
                    <label for="select">Parent Category</label>
                    <select id="categories" name="cat_name">
                        @foreach($categories as $cat)
                            @if($category->parent_id == $cat->id())
                                <option name="{{ $cat->title }}" value="{{ $cat->id()}}" selected>{{ $cat->title }}</option>
                            @else
                                <option value="{{$cat->id()}}">{{$cat->title}}</option>
                            @endif
                        @endforeach
                    </select>

                    <input type="text" name="category" placeholder="Category"/><br />
                    <input type="hidden" name="cat_type" value="post"/><br />
                    <p>Are you sure you want to edit the following category?</p>
                    <input type="radio" name="confirm" value="true" /> Yes
                    <input type="radio" name="confirm" value="false" checked="checked" /> No <br />
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@stop