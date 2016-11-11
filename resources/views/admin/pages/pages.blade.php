@extends('admin.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <a href="/admin/pages/new" class="link-btn">Add Page</a>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <div class="center">
                    <form class="backend-form" method="post" action="/admin/ages">
                        <table class="backend-table title">
                            <tr><th>Title</th><th>Author</th><th>Category</th><th>Date / Time</th><th>Edit</th><th>View</th><th><button type="button" id="check-all"><img class="glyph-small" alt="check-all-items" src="check.png"/></button></th></tr>
                            @each('admin.content.content-table',$pages,'single')
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop