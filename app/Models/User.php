<?php

namespace CMS\Models;

use CMS\Models\Traits\ModelActionsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable;
    use ModelActionsTrait;
    use Searchable;

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

    public function getPermissions(array $permissions)
    {
        return Permission::whereIn('name',$permissions)->get();
    }

    public function givePermissionTo(...$permissions)
    {
        $permissions = $this->getPermissions(array_flatten($permissions));

        if($permissions === null){
            return $this;
        }

        $this->permissions()->saveMany($permissions);

        return back();
        // get permission models
        // save manu to user permissions
    }
    
    public function revokePermissionTo(...$permissions){
        $permissions = $this->getPermissions(array_flatten($permissions));

        $this->permissions()->detach($permissions);

        return back();

    }

    public function refreshPermissions(...$permissions)
    {
        $this->permissions()->detach();

        $this->givePermissionTo(array_flatten($permissions));

        return back();
    }

    public function hasRole(...$roles): bool
    {
        foreach ($roles as $role){
            if ($this->roles->contains('name',$role)){
                return true;
            }
        }
        return false;
    }

    protected function hasPermission($permission): bool
    {
        return (bool) $this->permissions()->where('name', $permission->name)->count();
    }
    public function hasPermissionTo($permission)
    {
        // has permission through a role

        return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
    }

    public function hasPermissionThroughRole($permission){
        foreach ($permission->roles as $role){
            if ($this->roles->contains($role)){
                return true;
            }
        }
        return false;
    }

    #relations
    public function roles()
    {
        return $this->belongsToMany(Role::class,'users_roles','user_id','role_id');
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class,'users_permissions','user_id','permission_id');
    }
    public function permissionsThroughRole()
    {
        $roles = $this->roles;
        $permissions = [];
        foreach ($roles as $role) {
            foreach ($role->permissions as $permission){
                $permissions[] = $permission;
            }
        };
        return collect($permissions);
    }
}
