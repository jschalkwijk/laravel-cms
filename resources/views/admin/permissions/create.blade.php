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
                @if(isset($permission))
                    @php $action = route("permissions.update",$permission->role_id) @endphp
                @else
                    @php $action = route("permissions.store") @endphp
                @endif
                <form action="{{$action}}" method="post">
                    {{ csrf_field() }}
                    <input type="text" placeholder="Role name" value="{{isset($permission) ? $permission->name : old('name')}}"/>
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6">Permissions</th>
                        </thead>
                        <tbody>
                        <tr>
                            @php ($i = 1)
                            @foreach($roles as $role)
                                <td>
                                    @if(isset($currentRoles) && in_array($role->role_id,$currentRoles))
                                        <input type='checkbox' value='{{$role->role_id}}' name='checkbox[]' checked/>
                                    @else
                                        <input type='checkbox' value='{{$role->role_id}}' name='checkbox[]'/>
                                    @endif
                                </td>
                                <td><lable>{{ucfirst($role->name)}}</lable> </td>
                                @if ($i % 4 == 0)
                                </tr><tr> @php ($i++)
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