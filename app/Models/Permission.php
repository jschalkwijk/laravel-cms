<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $primaryKey = "permission_id";

    public function roles()
    {
        return $this->belongsToMany(Role::class,"roles_permissions");
    }
    public function users()
    {
        return $this->belongsToMany(User::class,"user_id");
    }

}
