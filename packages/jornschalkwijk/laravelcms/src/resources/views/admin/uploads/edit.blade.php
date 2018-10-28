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
                <form id="addpost-form" class="container large left" action="{{route('uploads.update',$upload->upload_id)}}" method="post">
                    {{ method_field('PATCH') }}
                    {{ csrf_field() }}
                    <input type="text" name="name" placeholder="Name" value="{{ old('name',$upload->name) }}"><br />
                    {{--<label for="select">Parent Category</label>--}}
                    {{--<select id="parent" name="parent_id">--}}
                        {{--@if($category->parent_id == 0)--}}
                            {{--<option value="0" selected>None</option>--}}
                        {{--@endif--}}
                        {{--@foreach($categories as $cat)--}}
                            {{--@if($category->parent_id == $cat->id())--}}
                                {{--<option value="{{ $cat->id()}}" selected>{{ $cat->title }}</option>--}}
                            {{--@else--}}
                                {{--<option value="{{$cat->id()}}">{{$cat->title}}</option>--}}
                            {{--@endif--}}
                        {{--@endforeach--}}
                    {{--</select>--}}

                    <p>Are you sure you want to edit the following file?</p>
                    <input type="radio" name="confirm" value="true" /> Yes
                    <input type="radio" name="confirm" value="false" checked="checked" /> No <br />
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@stop