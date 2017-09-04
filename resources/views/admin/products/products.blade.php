@extends('admin.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <a href="/admin/products/create" class="link-btn">Add Product</a>
                <a href="/admin/products/deleted-products" class="link-btn">Deleted products</a>
                <a href="/admin/categories" class="link-btn">Categories</a>
                <a href="/admin/categories/create" class="link-btn">Add Category</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                <div class="center">
                    @include('admin.products.products-table')
                </div>
            </div>
        </div>
    </div>
    
@stop