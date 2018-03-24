@extends('admin.layout')
@section('content')
    <div class="container-fluid">
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
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-sm-3 offset-md-3 offset-lg-3">
                @if(isset($user))
                    @php
                        $action = route("users.update",$user->user_id);
                        $method = 'PATCH';
                    @endphp
                @else
                    @php
                        $action = route("users.store");
                        $method = 'POST';
                    @endphp
                @endif
                <form action="{{$action}}" method="post">
                    {{method_field($method)}}
                    {{ csrf_field() }}
                    <input type="text" class="form-control" name="username" placeholder="Username" value="{{isset($user) ? $user->username : old('username')}}"/><br />
                    <input type="password" class="form-control" name="password" placeholder="New Password"/><br />
                    <input type="password" class="form-control" name="password_confirmation" placeholder="New Password Again"/><br />
                    <input type="text" class="form-control" name="first_name" placeholder="First name" value="{{isset($user) ? $user->first_name : old('first_name')}}"/> <br />
                    <input type="text" class="form-control" name="last_name" placeholder="Last name" value="{{isset($user) ? $user->last_name : old('last_name')}}"/> <br />
                    <input type="text" class="form-control" name="email" placeholder="Email" value="{{isset($user) ? $user->email : old('email')}}"/> <br />
                    <input type="text" class="form-control" name="function" placeholder="Function" value="{{isset($user) ? $user->function : old('function')}}"/> <br />

                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6">Roles</th>
                        </thead>
                        <tbody>
                        <tr>
                            @php($i = 1)
                            @foreach($roles as $role)
                                @if(isset($currentRoles) && in_array($role->role_id,$currentRoles))
                                    <td><input type='checkbox' value='{{$role->role_id}}' name='roles[]' checked/></td>
                                @else
                                    <td><input type='checkbox' value='{{$role->role_id}}' name='roles[]'/></td>
                                @endif

                                @foreach ($role->permissions as $perm)
                                    @php
                                        $permissionsID[] = $perm->permission_id;
                                    @endphp
                                @endforeach

                                <td><input id='{{'role_'.$role->role_id}}' class='{{$role->name}}' type='hidden' value='<?=json_encode($permissionsID)?>'/></td>
                                @php($permissionsID = [])

                                <td><label>{{ ucfirst($role->name) }}</label> </td>
                                @if ($i % 4 == 0)
                                    </tr><tr>
                                    @php($i++)
                                @endif
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6">Permissions</th>
                        </thead>
                        <tbody>
                        <tr>
                            @php($i = 1)
                            @foreach($permissions as $permission)
                                @if(isset($rolePermissions) && in_array($permission->permission_id,$rolePermissions))
                                    <td><input type='checkbox' value='{{$permission->permission_id}}' name='permissions[]' checked disabled/></td>
                                @elseif ( isset($userPermissions) && in_array($permission->permission_id,$userPermissions))
                                    <td><input type='checkbox' value='{{$permission->permission_id}}' name='permissions[]' checked /></td>
                                @else
                                   <td><input type='checkbox' value='{{$permission->permission_id}}' name='permissions[]'/></td>
                                @endif
                                    <td><lable>{{ ucfirst($permission->name)}}</lable></td>
                                @if ($i % 4 == 0)
                                    </tr><tr>
                                    @php($i++)
                                @endif
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                    <button type="submit" name="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
    <script src="{{ asset('js/users/users.js') }}"></script>
    @endpush
@stop
