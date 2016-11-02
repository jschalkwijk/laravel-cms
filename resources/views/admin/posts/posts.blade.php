@extends('admin.layout')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <a href="/admin/posts/new" class="link-btn">Add Post</a>
                <a href="/admin/categories" class="link-btn">Categories</a>
                <a href="/admin/categories/new" class="link-btn">Add Category</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <div class="center">
                    <form class="backend-form" method="post" action="/admin/posts">
                        <table class="backend-table title">
                            <tr><th>Title</th><th>Author</th><th>Category</th><th>Date / Time</th><th>Edit</th><th>View</th><th><button type="button" id="check-all"><img class="glyph-small" alt="check-all-items" src="check.png"/></button></th></tr>
                            @each('admin.content.content-table',$posts,'single')
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop