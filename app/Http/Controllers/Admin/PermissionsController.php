<?php

    namespace CMS\Http\Controllers\Admin;

    use Illuminate\Http\Request;
    use CMS\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Auth;

    use CMS\Models\UserActions;
    use CMS\Models\Action;
    use CMS\Models\Permission;
    use CMS\Models\Role;

    class PermissionsController extends Controller
    {
        use UserActions;

        public function index()
        {
            $permissions = Permission::all();

            return view('admin.permissions.permissions')->with(
                [
                    'permissions' => $permissions,
                    'template' => $this->adminTemplate()
                ]);
        }

        public function show(Permission $permission)
        {
            return "Permission";
        }

        public function deleted()
        {
            $permissions = Permission::all();
            return view('admin.permissions.permissions')->with(
                [
                    'permissions' => $permissions,
                    'template' => $this->adminTemplate()
                ]);
        }
        public function create()
        {
            $roles = Role::all();
            return view('admin.permissions.create')->with(['roles'=> $roles,'template'=>$this->adminTemplate()]);
        }
        /**
         * Create a new permission instance after a valid registration.
         *
         * @param  array  $data
         * @return Permission
         */
        public function store(Request $r)
        {
            $permission = Permission::create([

            ]);


            return redirect()->action('Admin\AdminController@index');
        }

        public function edit(Permission $permission)
        {
            $roles = Role::all();
            $currentRoles = $permission->roles->pluck('role_id')->toArray();
            return view('admin.permissions.create')->with(['permission'=>$permission,'roles' => $roles,'currentRoles'=>$currentRoles,'template' =>$this->adminTemplate()]);
        }
        public function update(Request $r,Permission $permission)
        {

            $permission->updated_by = Auth::permission()->permission_id;
            $permission->update($r->all());

            return redirect()->action('Admin\PermissionsController@index');
        }

        public function action(Request $r)
        {
            $this->Actions(new Permission(),$r);
            return back();
        }

        public function destroy($id)
        {
            $permissions = Permission::findOrFail($id);
            Permission::destroy($permissions->id());

            return back();
        }

        public function hide($id)
        {
            Action::hide(new Permission(),$id);
            return back();
        }

        public function approve($id)
        {
            Action::approve(new Permission(),$id);
            return back();
        }

        public function trash($id)
        {
            Action::trash(new Permission(),$id);
            return back();
        }
    }
