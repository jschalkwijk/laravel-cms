@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                <div class="display text-center">
                   <h1>{{ $page->title }}</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                <article>
                    <h1 class="article-title">{{$page->title}}</h1>
                    <p class="article-meta"><img class="glyph-small" src="author.png"/>
                        <span>{{ $page->user->username }}</span> <img class="glyph-small" src="time.png"/>
                    </p>
                    <div class="article-content"><p>{!! $page->content !!}</p></div>
                </article>
            </div>
        </div>
    </div>
    <script src="{{asset('js/reply/reply.js')}}"></script>
@stop