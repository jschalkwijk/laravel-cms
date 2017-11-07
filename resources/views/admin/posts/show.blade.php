@extends('admin.layout')
@section('content')
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
            <div class="center">
               {{ $post->title }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
            <div class="center">

                @foreach($post->comments as $c)
                    <h3>{{ $c->title }}</h3>
                    <article>{{ $c->content }}</article>
                    @if(!$c->replies->isEmpty())
                        @foreach($c->replies as $r)
                            <article>{{ $r->content }}</article>
                        @endforeach
                    @endif

                @endforeach
            </div>
        </div>
    </div>
@stop