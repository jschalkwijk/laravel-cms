@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-lg-6 offset-xs-3 offset-sm-3 offset-lg-3">
                <form class="form-inline" method="GET" action="{{route('folders.index')}}">
                    <input class="form-control mr-sm-2" type="search" name='search' placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                @if (count($errors))
                    @foreach($errors->all() as $error)
                        <div class="alert alert-warning">{{ $error }}</div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session()->get('success') }}</div>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 offset-md-3 col-lg-6 offset-lg-3">
                @include('JornSchalkwijk\LaravelCMS::admin.uploads.folders.folders-table')
            </div>
        </div>
    </div>
@stop