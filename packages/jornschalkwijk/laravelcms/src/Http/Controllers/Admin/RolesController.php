<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

use JornSchalkwijk\LaravelCMS\Models\Permission;
use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use JornSchalkwijk\LaravelCMS\Models\Role;

class RolesController extends Controller
{
    use ControllerActionsTrait;

    protected $model = Role::class;

    public function index()
    {
        $roles = Role::all();

        return view('admin.roles.roles')->with(
            [
                'roles' => $roles,
                'template' => $this->adminTemplate()
            ]);
    }

    public function show(Role $role)
    {
        return view('admin.roles.show')->with(['role' => $role,'template' =>$this->adminTemplate()]);
    }

    public function deleted()
    {
        $roles = Role::all();
        return view('admin.roles.roles')->with(
            [
                'roles' => $roles,
                'template' => $this->adminTemplate()
            ]);
    }
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create')->with(['template'=>$this->adminTemplate(),'permissions' => $permissions]);
    }
    /**
     * Create a new role instance after a valid registration.
     *
     * @param  array  $data
     * @return Role
     */
    public function store(Request $r)
    {
        $this->validate($r, [
            'name' => 'required|min:4',
        ]);

        $role = new Role($r->all());
        $role->save();

        $permissions = $r['permissions'];

        // Save selected tags, if all are deselected , detach all relations else sync selected
        (!is_array($permissions)) ? $role->permissions()->detach() : $role->permissions()->sync($permissions);

        return redirect()->action('Admin\RolesController@index');

    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('permission_id')->toArray();
        return view('admin.roles.edit')->with(['role'=>$role,'permissions' => $permissions,'rolePermissions' => $rolePermissions,'template' =>$this->adminTemplate()]);
    }
    public function update(Request $r,Role $role)
    {

        $this->validate($r, [
            'name' => 'required|min:4',
        ]);

        $role->update($r->all());

        $permissions = $r['permissions'];

        // Save selected tags, if all are deselected , detach all relations else sync selected
        (!is_array($permissions)) ? $role->permissions()->detach() : $role->permissions()->sync($permissions);

        return redirect()->action('Admin\RolesController@index');
    }
}
