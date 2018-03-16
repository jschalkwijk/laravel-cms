<?php

namespace CMS\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = "role_id";
    public $table = 'roles';
    public function id()
    {
        return $this->{$this->primaryKey};
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,"roles_permissions","role_id","permission_id");
    }
    public function users()
    {
        return $this->belongsToMany(User::class,'users_roles','role_id','user_id');
    }

}
