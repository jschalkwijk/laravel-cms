@extends('admin.layout')
@section('content')
    <div class="container-fluid">
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
                    <form class="backend-form" method="post" action="/admin/categories/action">
                        {{ csrf_field() }}
                        <table class="table table-sm table-striped">
                            <thead class="thead-default">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th class="hidden-xs-down">Author</th>
                                <th class="hidden-xs-down">Sub</th>
                                <th class="hidden-xs-down">Date/Time</th>
                                <th class="hidden-md-down">Edit</th>
                                <th>Status</th>
                                <th>Del</th>
                                <th>
                                    <button type="button" id="check-all"><img class="glyph-small" alt="check-all-items"
                                                                              src="check.png"/></button>
                                </th>
                            </tr>
                            <tbody>
                            @foreach($categories as $single)
                                @include('admin.content.content-table')
                            @endforeach
                            </tbody>
                        </table>
                        <table class="float-right">
                            <?php if($trashed === 0){ ?>
                            <tr><th></th><th>Trash</th><th>Show</th><th>Hide</th></tr>
                            <tr>
                                <td>On selected items</td>
                                <td><p><button class="btn btn-sm btn-danger form-action" type="submit" name="trash-selected" id="trash-selected"></button></p></td>
                                <td><p><button class="btn btn-sm btn-success form-action" type="submit" name="approve-selected" id="approve-selected"></button></p></td>
                                <td><p><button class="btn btn-sm btn-warning form-action" type="submit" name="hide-selected" id="hide-selected"></button></p></td>
                            </tr>
                            <?php } else if($trashed === 1){ ?>
                            <th>Restore</th><th>Remove</th></tr>
                            <tr>
                                <td>On selected items</td>
                                <td><p><button class="btn btn-sm btn-info form-action" type="submit" name="restore-selected" id="restore-selected"></button></p></td>
                                <td><p><button class="btn btn-sm btn-danger form-action" type="submit" name="delete-selected" id="delete-selected"></p></td>
                            </tr>
                            <?php } ?>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop