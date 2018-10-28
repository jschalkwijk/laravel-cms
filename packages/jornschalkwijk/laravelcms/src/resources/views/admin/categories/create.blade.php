@extends('JornSchalkwijk\LaravelCMS::admin.layout')
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
                <?php $action = '/admin/categories'; ?>
                <form id="addpost-form" class="container large left" action="{{$action}}" method="post">
                    {{ csrf_field() }}
                    <input type="text" name="title" placeholder="Title" value="{{ old('title')}}"><br />
                    <input type="text" name="post_desc" placeholder="Post Description (max 160 characters)" value="{{ old('description') }}"/><br />
                    <label for="select">Category</label>
                    <select id="categories" name="cat_name">
                        <option name="none" value="None">None</option>
                    </select>

                    <input type="text" name="category" placeholder="Category"/><br />
                    <input type="hidden" name="cat_type" value="post"/><br />
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@stop