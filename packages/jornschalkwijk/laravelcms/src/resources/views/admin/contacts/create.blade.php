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
                <?php $action = '/admin/users'; ?>

                <div class="center">
                    <form id="add-user" class="container medium" method="post" action="{{ $action }}">
                        {{ csrf_field() }}
                        <input type="text" name="username" placeholder="Username" value="{{ old('username') }}"/><br />
                        <input type="password" name="password" placeholder="New Password"/><br />
                        <input type="password" name="password_confirmation" placeholder="New Password Again"/><br />
                        <input type="text" name="first_name" placeholder="First name" value="{{ old('first_name')}}"/> <br />
                        <input type="text" name="last_name" placeholder="Last name" value="{{ old('last_name') }}"/> <br />
                        <input type="text" name="email" placeholder="Email" value="{{ old('email') }}"/> <br />
                        <input type="text" name="function" placeholder="Function" value="{{ old('function') }}"/> <br />
                        <p>Rights</p>
                        <input type="radio" name="rights" value="Admin"/>
                        <span> Admin | Can add new vacancies, approve and change them. Add/delete/change users and changes user rights/passwords.</span><br />
                        <input type="radio" name="rights" value="Content Manager"/>
                        <span> Content Manager | Can add new vacancies, approve and change them.</span><br />
                        <input type="radio" name="rights" value="Author" />
                        <span> Author | Can add new vacancies, change them. The changes made need approval from either a Admin or Content Manager.</span><br />
                        <p>Are you sure you want to edit this user?</p>
                        <input type="radio" name="confirm" value="Yes" /> Yes
                        <input type="radio" name="confirm" value="No" checked="checked" /> No <br />
                        <button type="submit" name="submit">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>



@stop