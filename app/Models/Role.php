<?php

namespace CMS\Models;

use CMS\Models\Traits\ModelActionsTrait;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use ModelActionsTrait;
    protected $primaryKey = "role_id";
    public $table = 'roles';

    protected $fillable = [
        'name'
    ];

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
