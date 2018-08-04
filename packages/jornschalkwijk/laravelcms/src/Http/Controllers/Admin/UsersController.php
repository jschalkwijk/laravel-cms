<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use CMS\Models\Permission;
use CMS\Models\Role;
use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
use CMS\Models\User;
use Illuminate\Http\Request;

use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    use ControllerActionsTrait;

    protected $model = User::class;

    protected $user;
    protected $permissions;

    public function index(Request $r)
    {
//        foreach(Auth::user()->permission as $perm){
//            $this->permissions[] = $perm->name;
//        };
//
//        if(!in_array("Create Post",$this->permissions)){ return "not allowed"; }

        if (isset($r['search'])) {
            $this->validate($r, [
                'search' => 'min:3',
            ]);
            $users = User::search($r['search'])->get();
        } else {
            $users = User::where('users.trashed', 0)->orderBy('user_id', 'desc')->get();
        }
        return view('admin.users.users')->with(
        [
            'users' => $users,
            'trashed' => 0,
            'template' => $this->adminTemplate()
        ]);
    }

    public function show(User $user)
    {
        return view('admin.users.show')->with(['user'=>$user,'template' => $this->adminTemplate()]);
    }

    public function deleted()
    {
        $users = User::where('users.trashed',1)->orderBy('user_id','desc')->get();
        return view('admin.users.users')->with(
            [
                'users' => $users,
                'trashed' => 1,
                'template' => $this->adminTemplate()
            ]);
    }
    public function create()
    {
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.users.create')->with(['roles'=>$roles,'permissions'=> $permissions,'template'=>$this->adminTemplate()]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function store(Request $r)
    {
        $this->validator($r->all())->validate();

        $user = new User([
            'username' => $r['username'],
            'password' => bcrypt($r['password']),
            'email' => $r['email'],
            'first_name' =>$r['first_name'],
            'last_name' => $r['last_name'],
            'dob' => $r['dob'],
            'function' => $r['function'],
//            'created_by' => Auth::user()->user_id,
        ]);

        $user->save();
        event(new Registered($user));

        (!is_array($r['roles'])) ? $user->roles()->detach() : $user->roles()->sync($r['roles']);
        (!is_array($r['permissions'])) ? $user->permissions()->detach() : $user->permissions()->sync($r['permissions']);

        return redirect()->action('Admin\UsersController@index');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $currentRoles = $user->roles->pluck('role_id')->toArray();
        $permissions = Permission::all();
        $rolePermissions = $user->permissionsThroughRole()->pluck('permission_id')->toArray();
        $userPermissions = $user->permissions->pluck('permission_id')->toArray();

        return view('admin.users.edit')->with(
            [
                'user' => $user,
                'roles'=> $roles,
                'currentRoles' => $currentRoles,
                'permissions' => $permissions,
                'rolePermissions' => $rolePermissions,
                'userPermissions' => $userPermissions,
                'template' => $this->adminTemplate()
            ]);
    }
    public function update(Request $r,User $user)
    {
        $this->validator($r->all(),$user->user_id)->validate();

        $user->updated_by = Auth::user()->user_id;
        $user->update($r->all());

        (!is_array($r['roles'])) ? $user->roles()->detach() : $user->roles()->sync($r['roles']);
        (!is_array($r['permissions'])) ? $user->permissions()->detach() : $user->permissions()->sync($r['permissions']);

        return redirect()->action('Admin\UsersController@index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data,$user_id = 0)
    {
        return Validator::make($data, [
            'username' => [
                'required','max:255',
                Rule::unique('users')->ignore($user_id,'user_id'),
            ],
            'email' => [
                'required','email','max:255',
                Rule::unique('users')->ignore($user_id,'user_id'),
            ],
            'password' => 'required|min:6|alpha_num|confirmed',
            'first_name' => 'alpha',
            'last_name' => 'alpha',
            'dob' => 'date',
            'function' => 'alpha',
        ]);
    }
}
