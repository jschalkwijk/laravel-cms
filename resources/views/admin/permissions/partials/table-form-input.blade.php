<table class="table">
    <thead>
    <tr>
        <th class="text-center" colspan="6">Permissions</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <?php
        $i = 1;
        foreach($permissions as $permission){
        if(isset($rolePermissions) && in_array($permission->permission_id,$rolePermissions)) {
            echo "<td><input type='checkbox' value='$permission->permission_id' name='permissions[]' checked disabled/></td>";
        } else if( isset($userPermissions) && in_array($permission->permission_id,$userPermissions)){
            echo "<td><input type='checkbox' value='$permission->permission_id' name='permissions[]' checked /></td>";
        } else {
            echo "<td><input type='checkbox' value='$permission->permission_id' name='permissions[]'/></td>";
        }
        ?>
        <td><lable><?= ucfirst($permission->name)?></lable></td>
        <?php if ($i % 4 == 0) echo "</tr><tr>"; $i++;?>
        <?php } ?>

        {{--@php($i = 1)--}}

        {{--@foreach($permissions as $permission)--}}
            {{--@if(isset($rolePermissions) && in_array($permission->permission_id,$rolePermissions))--}}
                {{--<td><input type='checkbox' value='$permission->permission_id' name='permissions[]' checked disabled/></td>--}}
            {{--@elseif(isset($userPermissions) && in_array($permission->permission_id,$userPermissions))--}}
                {{--<td><input type='checkbox' value='$permission->permission_id' name='permissions[]' checked /></td>--}}
            {{--@else--}}
                {{--<td><input type='checkbox' value='$permission->permission_id' name='permissions[]'/></td>--}}
            {{--@endif--}}
            {{--<td><lable><?= ucfirst($permission->name)?></lable></td>--}}
            {{--@if($i % 4 == 0)--}}
                 {{--</tr><tr>--}}
                 {{--@php($i++)--}}
            {{--@endif--}}
        {{--@endforeach--}}
    </tr>
    </tbody>
</table>