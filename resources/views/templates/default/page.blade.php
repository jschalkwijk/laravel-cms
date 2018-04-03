@extends('templates.default.layout')
@section('content')
    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1>{{ $page->title }}</h1>
            <p>Bootstrap is the most popular HTML, CSS...</p>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                <article>
                    <div class="article-content"><p>{!! $page->content !!}</p></div>
                </article>
            </div>
        </div>
    </div>
@stop