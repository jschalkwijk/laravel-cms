@extends('admin.layout')
@section('content')
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
            <div class="center">
               {{ $post->title }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-xs-3 offset-sm-3 offset-md-2 offset-lg-3">
            <div class="center">

                @foreach($post->comments as $c)
                    <h3>{{ $c->title }}</h3>
                    <article>{{ $c->content }}</article>
                    @if(!$c->replies->isEmpty())
                        @foreach($c->replies as $r)
                            <article>{{ $r->content }}</article>
                        @endforeach
                    @endif

                @endforeach
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
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item active"><a class="nav-link" href="#comments-logout" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Comments</h4></a></li>
                        <li class="nav-item"><a class="nav-link" href="#add-comment" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Add comment</h4></a></li>
                        <li class="nav-item"><a class="nav-link" href="#account-settings" role="tab" data-toggle="tab"><h4 class="reviews text-capitalize">Account settings</h4></a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="comments-logout">
                            <ul class="comment-list">
                                <li class="comment">
                                    <a class="float-left" href="#">
                                        <img class="comment-object rounded-circle" src="https://s3.amazonaws.com/uifaces/faces/twitter/dancounsell/128.jpg" alt="profile">
                                    </a>
                                    <div class="comment-body">
                                        <h4 class="comment-heading text-uppercase reviews">Marco </h4>
                                        <ul class="comment-date text-uppercase reviews list-inline">
                                            <li class="list-inline-item dd">22</li>
                                            <li class="list-inline-item mm">09</li>
                                            <li class="list-inline-item aaaa">2014</li>
                                        </ul>
                                        <p class="comment-text">
                                            Great snippet! Thanks for sharing.
                                        </p>
                                        <a class="btn btn-info btn-circle text-uppercase" href="#" id="reply"><span class="glyphicon glyphicon-share-alt"></span> Reply</a>
                                        <a class="btn btn-warning btn-circle text-uppercase" data-toggle="collapse" href="#replyOne"><span class="glyphicon glyphicon-comment"></span> 2 comments</a>
                                    </div>
                                    <div class="collapse" id="replyOne">
                                        <ul class="comment-list">
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
                                                        Nice job Maria.
                                                    </p>
                                                    <a class="btn btn-info btn-circle text-uppercase" href="#" id="reply"><span class="glyphicon glyphicon-share-alt"></span> Reply</a>
                                                </div>
                                            </li>
                                            <li class="comment comment-replied" id="replied">
                                                <a class="float-left" href="#">
                                                    <img class="comment-object rounded-circle" src="https://pbs.twimg.com/profile_images/442656111636668417/Q_9oP8iZ.jpeg" alt="profile">
                                                </a>
                                                <div class="comment-body">
                                                        <h4 class="comment-heading text-uppercase reviews"><span class="glyphicon glyphicon-share-alt"></span> Mary</h4></h4>
                                                        <ul class="comment-date text-uppercase reviews list-inline">
                                                            <li class="list-inline-item dd">22</li>
                                                            <li class="list-inline-item mm">09</li>
                                                            <li class="list-inline-item aaaa">2014</li>
                                                        </ul>
                                                        <p class="comment-text">
                                                            Thank you Guys!
                                                        </p>
                                                        <a class="btn btn-info btn-circle text-uppercase" href="#" id="reply"><span class="glyphicon glyphicon-share-alt"></span> Reply</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="add-comment">
                            <form action="#" method="post" class="form-horizontal" id="commentForm" role="form">
                                <div class="form-group">
                                    <label for="email" class="col-sm-2 control-label">Comment</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="addComment" id="addComment" rows="5"></textarea>
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
                                        <button class="btn btn-success btn-circle text-uppercase" type="submit" id="submitComment"><span class="glyphicon glyphicon-send"></span> Summit comment</button>
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