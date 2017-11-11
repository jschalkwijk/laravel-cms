@extends('admin.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                <div class="display text-center">
                   <h1>{{ $post->title }}</h1>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
                <article>
                    <h1 class="article-title">{{$post->title}}</h1>
                    <p class="article-meta"><img class="glyph-small" src="author.png"/>
                        <span>{{ $post->users_username }}</span> <img class="glyph-small" src="time.png"/>
                        <img class="glyph-small" src="category.png>"/>
                        <span><a a href="/blog/category/{{$post->category_id}}/{{$post->categories_title}}">{{$post->categories_title}}</a></span>
                        <img class="glyph-small" src="comments.png"/>
                        <span>
                            @if($post->comments->isEmpty())
                                {{ 0 }}
                            @else
                                {{$post->comments->count()}}
                            @endif
                        </span>
                    </p>
                    <div class="article-content"><p>{!! $post->content !!}</p>
                </article>
            </div>
        </div>
    </div>
    <div id="comment-section" class="container-fluid">
        <div class="row">
            <div class="col-sm-10 offset-sm-1" id="logout">
                <div class="page-header">
                    <h3 class="reviews">Leave your comment</h3>
                    <div class="logout">
                        <button class="btn btn-default btn-circle text-uppercase" type="button" onclick="$('#logout').hide(); $('#login').show()">
                            <span class="glyphicon glyphicon-off"></span> Logout
                        </button>
                    </div>
                </div>
                <div class="comment-tabs">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-sm-offset-3 col-md-offset-3">
                            @if (count($errors))
                                @foreach($errors->all() as $error)
                                    <div class="alert alert-warning">{{ $error }}</div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"><a class="nav-link active" href="#comments" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Comments</h4></a></li>
                        <li class="nav-item"><a class="nav-link" href="#add-comment" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Add comment</h4></a></li>
                        <li class="nav-item"><a class="nav-link" href="#account-settings" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Account settings</h4></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="comments">
                            <ul class="comment-list">
                                @foreach($post->comments as $c)
                                    <li class="comment">
                                        <a class="float-left" href="#">
                                            <img class="comment-object rounded-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/dancounsell/128.jpg" alt="profile">
                                        </a>
                                        <div class="comment-body">
                                            <h4 class="comment-heading text-uppercase reviews">Marco </h4>
                                            <ul class="comment-date text-uppercase reviews list-inline">
                                                <li class="list-inline-item dd">{{$c->created_at}}</li>
                                            </ul>
                                            <p class="comment-text">
                                                {{ $c->content }}
                                            </p>
                                            <a class="btn btn-info btn-circle text-uppercase" href="#" id="reply"><span class="glyphicon glyphicon-share-alt"></span> Reply</a>
                                            <a class="btn btn-warning btn-circle text-uppercase" data-toggle="collapse" href="#reply-{{ $loop->iteration }}">
                                                <span class="glyphicon glyphicon-comment">
                                                </span>
                                                @if($c->replies->isEmpty())
                                                    {{ 0 }}
                                                @else
                                                    {{$c->replies->count().' Replies'}}
                                                @endif
                                            </a>
                                            {{--<form id="add-comment-47238022" class=""--}}
                                                  {{--data-placeholdertext="Use comments to ask for more information or suggest improvements. Avoid comments like “+1” or “thanks”.">--}}
                                                {{--<table>--}}
                                                    {{--<tbody class="js-comment-form-layout">--}}
                                                    {{--<tr>--}}
                                                        {{--<td>--}}
                                                            {{--<ul id="tabcomplete"></ul>--}}
                                                            {{--<textarea name="comment" cols="68" rows="3"--}}
                                                                      {{--placeholder="Use comments to ask for more information or suggest improvements. Avoid comments like “+1” or “thanks”."></textarea>--}}
                                                        {{--</td>--}}
                                                        {{--<td><input tabindex="0" type="submit" value="Add Comment"><br><a--}}
                                                                    {{--tabindex="0" class="comment-help-link">help</a></td>--}}
                                                    {{--</tr>--}}
                                                    {{--<tr>--}}
                                                        {{--<td colspan="2"><span class="text-counter cool">enter at least 15 characters</span><span--}}
                                                                    {{--class="form-error"></span></td>--}}
                                                    {{--</tr>--}}
                                                    {{--</tbody>--}}
                                                {{--</table>--}}
                                            {{--</form>--}}
                                        </div>
                                        @if(!$c->replies->isEmpty())
                                            <div class="collapse" id="reply-{{ $loop->iteration }}">
                                                <ul class="comment-list">
                                                    @if(!$c->replies->isEmpty())
                                                        @foreach($c->replies as $r)
                                                            <li class="comment comment-replied">
                                                                <a class="float-left" href="#">
                                                                    <img class="comment-object rounded-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/ManikRathee/128.jpg" alt="profile">
                                                                </a>
                                                                <div class="comment-body">
                                                                    <h4 class="comment-heading text-uppercase reviews"><span class="glyphicon glyphicon-share-alt"></span> The Hipster</h4>
                                                                    <ul class="comment-date text-uppercase reviews list-inline">
                                                                        <li class="list-inline-item dd">22</li>
                                                                        <li class="list-inline-item mm">09</li>
                                                                        <li class="list-inline-item aaaa">2014</li>
                                                                    </ul>
                                                                    <p class="comment-text">
                                                                        {{ $r->content }}
                                                                    </p>
                                                                    <a class="btn btn-info btn-circle text-uppercase" href="#" id="reply"><span class="glyphicon glyphicon-share-alt"></span> Reply</a>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    @endif
                                                </ul>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                      {{--New Comment--}}
                        <div class="tab-pane" id="add-comment">
                            <form action="{{route('comments.store')}}" method="post" class="form-horizontal" id="commentForm" role="form">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="addComment" class="col-sm-2 control-label">Comment</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="content" id="addComment" rows="5"></textarea>
                                        <input type="hidden" name="post_id" value="{{$post->id()}}"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="uploadMedia" class="col-sm-2 control-label">Upload comment</label>
                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div class="input-group-addon">http://</div>
                                            <input type="text" class="form-control" name="uploadMedia" id="uploadMedia">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button class="btn btn-success btn-circle text-uppercase" type="submit" id="submitComment"><span class="glyphicon glyphicon-send"></span> Submit comment</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane" id="account-settings">
                            <form action="#" method="post" class="form-horizontal" id="accountSetForm" role="form">
                                <div class="form-group">
                                    <label for="avatar" class="col-sm-2 control-label">Avatar</label>
                                    <div class="col-sm-10">
                                        <div class="custom-input-file">
                                            <label class="uploadPhoto">
                                                Edit
                                                <input type="file" class="change-avatar" name="avatar" id="avatar">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name" class="col-sm-2 control-label">Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="name" id="name" placeholder="Vilma palma">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nickName" class="col-sm-2 control-label">Nick name</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="nickName" id="nickName" placeholder="Vilma">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" name="email" id="email" placeholder="vilma@mail.com">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="newPassword" class="col-sm-2 control-label">New password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="newPassword" id="newPassword">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="confirmPassword" class="col-sm-2 control-label">Confirm password</label>
                                    <div class="col-sm-10">
                                        <input type="password" class="form-control" name="confirmPassword" id="confirmPassword">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button class="btn btn-primary btn-circle text-uppercase" type="submit" id="submit">Save changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop