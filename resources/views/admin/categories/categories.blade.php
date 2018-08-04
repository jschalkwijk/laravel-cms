@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-lg-6 offset-xs-3 offset-sm-3 offset-lg-3">
                <form class="form-inline" method="GET" action="{{route('categories.index')}}">
                    <input class="form-control mr-sm-2" type="search" name='search' placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-lg-6 offset-xs-3 offset-sm-3 offset-lg-3">
                <div class="center button-block">
                    <a href="/admin/category/create" class="btn btn-primary btn-sm visible-md-block">Add Category</a>
                    <a href="/admin/categories/deleted-categories" class="btn btn-primary visible-md-block">Deleted Categories</a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                <div class="center">
                    @include('admin.categories.categories-table')
                </div>
            </div>
        </div>
    </div>
@stop