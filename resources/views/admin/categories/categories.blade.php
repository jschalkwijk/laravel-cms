@extends('admin.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <a href="/admin/categories/new" class="link-btn">Add Category</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <div class="center">
                    <form class="backend-form" method="post" action="/admin/categories">
                        <table class="backend-table title">
                            <tr><th>Name</th><th>Author</th><th>Sub</th><th>Date/Time</th><th>Edit</th><th>View</th></tr>
                            @each('admin.content.content-table',$categories,'single')
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop