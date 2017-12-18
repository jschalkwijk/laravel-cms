<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = "role_id";

    public function permissions()
    {
        return $this->belongsToMany(Permission::class,"roles_permissions");
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

}
