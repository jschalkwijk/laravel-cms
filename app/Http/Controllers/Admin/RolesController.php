<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\Permission;
use Illuminate\Http\Request;
use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use CMS\Models\UserActions;
use CMS\Models\Action;
use CMS\Models\Role;

class RolesController extends Controller
{
    use UserActions;

    public function index()
    {
        $roles = Role::all()->orderBy('role_id','desc')->get();

        return view('admin.roles.roles')->with(
            [
                'roles' => $roles,
                'template' => $this->adminTemplate()
            ]);
    }

    public function show(Role $role)
    {
        return "Role";
    }

    public function deleted()
    {
        $roles = Role::all()->orderBy('role_id','desc')->get();
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
        $role = Role::create([

        ]);


        return redirect()->action('Admin\AdminController@index');
    }

    public function edit(Role $role)
    {
        return view('admin.roles.create')->with(['role'=>$role,'template' =>$this->adminTemplate()]);
    }
    public function update(Request $r,Role $role)
    {

        $role->updated_by = Auth::role()->role_id;
        $role->update($r->all());

        return redirect()->action('Admin\RolesController@index');
    }

    public function action(Request $r)
    {
        $this->Actions(new Role(),$r);
        return back();
    }

    public function destroy($id)
    {
        $roles = Role::findOrFail($id);
        Role::destroy($roles->id());

        return back();
    }

    public function hide($id)
    {
        Action::hide(new Role(),$id);
        return back();
    }

    public function approve($id)
    {
        Action::approve(new Role(),$id);
        return back();
    }

    public function trash($id)
    {
        Action::trash(new Role(),$id);
        return back();
    }
}
