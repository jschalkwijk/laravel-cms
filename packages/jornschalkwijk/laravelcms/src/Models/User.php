<?php

namespace JornSchalkwijk\LaravelCMS\Models;

use JornSchalkwijk\LaravelCMS\Models\Elasticsearch\UserIndexConfigurator;
use JornSchalkwijk\LaravelCMS\Models\Traits\ModelActionsTrait;
use Illuminate\Notifications\Notifiable;
use ScoutElastic\Searchable;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use ModelActionsTrait;
    use Searchable;

    protected $indexConfigurator = UserIndexConfigurator::class;

    protected $searchRules = [
        //
    ];

    // Here you can specify a mapping for a model fields.
    protected $mapping = [
        'properties' => [
            'user_id' => [
                'type' => 'integer',
                'fields' => [
                    'raw' => [
                        'type' => 'integer',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'username' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'analyzer' => 'english'
                    ]
                ]
            ],
            'password' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'first_name' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'analyzer' => 'english'
                    ]
                ]
            ],
            'last_name' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'analyzer' => 'english'
                    ]
                ]
            ],
            'dob' => [
                'type' => 'date',
                'fields' => [
                    'raw' => [
                        'type' => 'date',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'email' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'analyzer' => 'english'
                    ]
                ]
            ],
            'function' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'analyzer' => 'english'
                    ]
                ]
            ],
            'img_path' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],

            'album_id' => [
                'type' => 'integer',
                'fields' => [
                    'raw' => [
                        'type' => 'integer',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'remember_token' => [
                'type' => 'string',
                'fields' => [
                    'raw' => [
                        'type' => 'string',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'created_at' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'index' => 'not_analyzed',
            ],
            'updated_at' => [
                'type' => 'date',
                'format' => 'yyyy-MM-dd HH:mm:ss',
                'index' => 'not_analyzed'
            ],
             'trashed' => [
                'type' => 'integer',
                'fields' => [
                    'raw' => [
                        'type' => 'integer',
                        'index' => 'not_analyzed'
                    ]
                ]
            ],
            'approved' => [
                'type' => 'integer',
                'fields' => [
                    'raw' => [
                        'type' => 'integer',
                        'index' => 'not_analyzed'
                    ]
                ]
            ]
        ]
    ];

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
