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
                @if (isset($tag->tag_id))
                    <?php $action = '/admin/tags/'.$tag->tag_id; $method = 'PATCH'; ?>
                @endif

                <form id="addpost-form" class="container large left" action="{{$action}}" method="post">
                    {{ method_field($method) }}
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="{{$tag->post_id}}"/>
                    <input type="text" name="title" placeholder="Title" value="{{ $tag->title }}"><br />
                    <p>Are you sure you want to edit the following tag?</p>
                    <input type="radio" name="confirm" value="true" /> Yes
                    <input type="radio" name="confirm" value="false" checked="checked" /> No <br />
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@stop