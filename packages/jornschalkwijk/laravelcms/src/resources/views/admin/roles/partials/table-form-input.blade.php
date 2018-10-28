<table class="table">
    <thead>
    <tr>
        <th class="text-center" colspan="6">Roles</th>
    </thead>
    <tbody>
    <tr>
        <?php
        $i = 1;
        foreach($roles as $role){
        if(isset($currentRoles) && in_array($role->role_id,$currentRoles)) {
            echo "<td><input type='checkbox' value='$role->role_id' name='roles[]' checked/></td>";
        } else {
            echo "<td><input type='checkbox' value='$role->role_id' name='roles[]'/></td>";
        }

        foreach ($role->permissions as $perm){
            $permissionsID[] = $perm->permission_id;
        }
        echo "<td><input id='role_$role->role_id' class='$role->name' type='hidden' value='".json_encode($permissionsID)."'/></td>";
        $permissionsID = [];
        ?>

        <td><label><?= ucfirst($role->name) ?></label> </td>
        <?php if ($i % 4 == 0) echo "</tr><tr>"; $i++;?>
        <?php } ?>
    </tr>
    </tbody>
</table>