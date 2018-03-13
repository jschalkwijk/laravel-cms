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

                <form action="{{route("permissions.store",$permission->permission_id)}}" method="post">
                    {{ csrf_field() }}
                    <input type="text" placeholder="Role name" value="{{$permission->name}}"/>
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center" colspan="6">Permissions</th>
                        </thead>
                        <tbody>
                        <tr>
                            @php ($i = 1)
                            @foreach($roles as $role){
                                <td>
                                    @if(isset($currentRoles) && in_array($role->role_id,$currentRoles))
                                        <input type='checkbox' value='{{$role->role_id}}' name='checkbox[]' checked/>
                                    @else
                                        <input type='checkbox' value='{{$role->role_id}}' name='checkbox[]'/>
                                    @endif
                                </td>
                                <td><lable>@php (ucfirst($role->name))</lable> </td>
                                @if ($i % 4 == 0)
                                </tr><tr> @php ($i++)
                                @endif
                            @endforeach
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>
@stop