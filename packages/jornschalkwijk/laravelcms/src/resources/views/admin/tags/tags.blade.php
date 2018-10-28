@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                @if (count($errors))
                    @foreach($errors->all() as $error)
                        <div class="alert alert-warning">{{ $error }}</div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <?php $action = '/admin/tags'; ?>
                <form id="addpost-form" action="{{$action}}" method="post">
                    {{ csrf_field() }}
                    <input type="text" name="title" placeholder="Title" value="{{ old('title')}}"><br />
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                <div class="center">
                    <form class="backend-form" method="post" action="/admin/tags/action">
                        {{ csrf_field() }}
                        <table class="backend-table title">
                            <tr><th>Name</th><th>Author</th><th>Date/Time</th><th>Edit</th><th>View</th></tr>
                            @each('JornSchalkwijk\LaravelCMS::admin.content.content-table',$tags,'single')
                        </table>
                        <table>
                            <tr><th>Delete</th><th>Show</th><th>Hide</th></tr>
                            <tr>
                                <td><p><button type="submit" name="delete-selected" id="delete-selected"><img class="glyph-small" alt="delete-selected-from-trash" src="<?= 'delete-post.png'?>"/></button></p></td>
                                <td><p><button type="submit" name="approve-selected" id="approve-selected"><img class="glyph-small" alt="approve-selected-for-front-end-view" src="<?= 'show.png'?>"/></button></p></td>
                                <td><p><button type="submit" name="hide-selected" id="hide-selected"><img class="glyph-small" alt="hide-selected-from-front-end-view" src="<?= 'hide.png'?>"/></button></p></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop