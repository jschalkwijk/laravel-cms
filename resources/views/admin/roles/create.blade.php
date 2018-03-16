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
                @if(isset($role))
                    @php $action = route("roles.update",$role->role_id) @endphp

                @else
                    @php $action = route("roles.store") @endphp
                @endif
                <form action="{{$action}}" method="post">
                    {{ csrf_field() }}
                    <input type="text" placeholder="Role name" value="{{isset($role) ? $role->name : old('name') }}"/>
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6">Permissions</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            @php $i = 1 @endphp
                            @foreach($permissions as $permission)
                                <td>
                                @if(isset($currentPermissions) && in_array($permission->permission_id,$currentPermissions))
                                        <input type='checkbox' value='{{$permission->permission_id}}' name='checkbox[]' checked/>
                                    @else
                                   <input type='checkbox' value='{{$permission->permission_id}}' name='checkbox[]'/>
                                @endif
                                    </td>
                                <td><lable>{{ucfirst($permission->name)}}</lable> </td>
                                @if ($i % 4 == 0)
                                    </tr><tr> @php $i++ @endphp
                                @endif
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
@stop