<?php

namespace CMS\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    public $permissions = [];

    public $table = 'users';

    protected $primaryKey = 'user_id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'rights',
        'first_name',
        'last_name',
        'dob',
        'function',
        'img_path',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function id()
    {
        return $this->user_id;
    }

    public function hasRole(...$roles)
    {
        foreach ($roles as $role){
            if ($this->roles->contains('name',strtolower($role))){
                return true;
            }
        }
         return false;
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles');
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'users_permissions');
    }
}
