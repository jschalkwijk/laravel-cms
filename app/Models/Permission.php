<?php

namespace CMS\Models;

use CMS\Models\Traits\ModelActionsTrait;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use ModelActionsTrait;
    protected $primaryKey = "permission_id";
    public $table = 'permissions';

    protected $fillable = [
        'name',
    ];

    public function id()
    {
        return $this->{$this->primaryKey};
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,"roles_permissions","permission_id","role_id");
    }
    public function users()
    {
        return $this->belongsToMany(User::class,"users_permissions",'permission_id','user_id');
    }

}
