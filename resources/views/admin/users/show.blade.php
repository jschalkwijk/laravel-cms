@extends('templates.default.layout')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 offset-sm-3 offset-md-3 offset-lg-3">
                <table class="table">
                    <tbody>
                    <tr><td><?= $user->first_name; ?></td><td><?= $user->last_name; ?></td></tr>
                    <tr><td><?= $user->mail; ?></td><td><?= $user->function; ?></td></tr>
                    </tbody>
                </table>

                <table class="table">
                    <thead>
                    <tr>
                        <th class="text-center" colspan="6">Roles</th>
                    </thead>
                    <tbody>
                    <tr>
                        @php($i = 1)
                        @foreach($user->roles as $role)
                            <td><a href="{{route('roles.show',$role->role_id)}}"> {{ ucfirst($role->name) }}</a> </td>
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
                        @foreach($user->roles as $role)
                            @foreach($role->permissions as $permission)
                                <td><a href="{{ route('permissions.show',$permission->permissions_id) }}"> {{ ucfirst($permission->name) }}</a> </td>
                                @if ($i % 4 == 0)
                                    </tr><tr>
                                    @php($i++)
                                @endif
                            @endforeach
                        @endforeach
                        @php($i = 1)
                            @foreach($user->permissions as $permission)
                                <td><a href="{{route('permissions.show',$permission->permission_id)}}"> {{ ucfirst($permission->name) }}</a> </td>
                                @if ($i % 4 == 0)
                                    </tr><tr>
                                    @php($i++)
                                @endif
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop