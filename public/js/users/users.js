Array.prototype.diff = function (a) {
    return this.filter(function (i) {
        return a.indexOf(i) === -1;
    });
};

Array.prototype.unique = function() {
    var a = this.concat();
    for(var i=0; i<a.length; ++i) {
        for(var j=i+1; j<a.length; ++j) {
            if(a[i] === a[j])
                a.splice(j--, 1);
        }
    }
    return a;
};

// Pass the checkbox name to the function
function getCheckedBoxes(checkboxName) {
    var checkboxes = document.getElementsByName(checkboxName);
    var checkboxesChecked = [];
    // loop over them all
    for (var i=0; i<checkboxes.length; i++) {
        // And stick the checked ones onto an array...
        if (checkboxes[i].checked) {
            checkboxesChecked.push(checkboxes[i]);
        }
    }
    // Return the array if it is non-empty, or null
    return checkboxesChecked.length > 0 ? checkboxesChecked : null;
}

function checkPermissions() {
   var roles = document.getElementsByName("roles[]");
   var permissions = document.getElementsByName("permissions[]");
    var count;
    for(var i = 0; i < roles.length; i++) {
        (function(i){
            var check = roles[i];
            // console.log("Role" + check.className + " checked: " +check.checked);
            check.onclick = function () {
                // Convert JSON string containing the permissions_id's To javascript object.
                var rolePermissions = document.getElementById('role_'+check.value).value;
                console.log(typeof rolePermissions)
                // Check permissions that belong to the role if they are in the rolePermissions array;
                if(check.checked === true){
                    for(var j = 0; j < permissions.length; j++){
                        var inArray = rolePermissions.includes(permissions[j].value);
                        console.log(inArray)
                        if(inArray){
                            console.log(permissions[j]);
                            permissions[j].checked = true;
                            permissions[j].disabled = true;
                        }
                    }
                } else {
                    count = 0;
                    var checkedRolePermissions = [];
                    var uncheck = [];

                    for(var x = 0; x < roles.length;x++){
                        if(roles[x].checked === true ){
                            count++;
                            // Convert JSON string containing the permissions_id's that should be checked is a role is checked to javascript object.
                            // add only unique values to the array.
                            checkedRolePermissions = checkedRolePermissions.concat(JSON.parse(document.getElementById('role_'+roles[x].value).value)).unique();
                            uncheck = uncheck.concat(JSON.parse(rolePermissions).diff(checkedRolePermissions)).unique();
                        }
                    }
                    // console.log("role permissions "+rolePermissions)
                    // console.log("checked role permissions "+checkedRolePermissions)
                    // console.log("uncheck "+uncheck);

                    // Uncheck permissions in the uncheck array
                    var checkedPermissions = getCheckedBoxes("permissions[]");
                    // If no roles are checked, uncheck all checked permissions
                    if(count === 0 && checkedPermissions !== null){
                        for(var y = 0; y < checkedPermissions.length; y++){
                            checkedPermissions[y].checked = false;
                            checkedPermissions[y].disabled = false;
                        }
                        // if one or more roles are checked only uncheck the inputs where the value is in uncheck array
                    } else if(checkedPermissions !== null) {
                        console.log('typeOf checkedPermissions: '+typeof checkedPermissions);
                        console.log("checkedPermissions "+checkedPermissions);
                        console.log('typeOf unckeck: '+typeof uncheck);
                        console.log("uncheck values"+uncheck);

                        for(var z = 0; z < checkedPermissions.length; z++){
                            console.log('checkedPermissions value: '+checkedPermissions[z].value);

                            var inArray2 = uncheck.includes(checkedPermissions[z].value);
                            console.log(checkedPermissions[z].value+' in array :'+inArray2);
                            if(inArray2){
                                checkedPermissions[z].checked = false;
                                checkedPermissions[z].disabled = false;
                            }
                        }
                    }
                }
            }

        })(i);
    }
}
addLoadEvent(checkPermissions);