<?php

    namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin;

    use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Traits\ControllerActionsTrait;
    use Illuminate\Http\Request;

    use JornSchalkwijk\LaravelCMS\Models\Permission;
    use JornSchalkwijk\LaravelCMS\Models\Role;

    class PermissionsController extends Controller
    {
        use ControllerActionsTrait;

        protected $model = Permission::class;

        public function index()
        {
            $permissions = Permission::all();

            return view('JornSchalkwijk\LaravelCMS::admin.permissions.permissions')->with(
                [
                    'permissions' => $permissions,
                    'template' => $this->adminTemplate()
                ]);
        }

        public function show(Permission $permission)
        {
            return view('JornSchalkwijk\LaravelCMS::admin.permissions.show')->with(['permission' => $permission,'template' =>$this->adminTemplate()]);
        }

        public function deleted()
        {
            $permissions = Permission::all();
            return view('JornSchalkwijk\LaravelCMS::admin.permissions.permissions')->with(
                [
                    'permissions' => $permissions,
                    'template' => $this->adminTemplate()
                ]);
        }
        public function create()
        {
            $roles = Role::all();
            return view('JornSchalkwijk\LaravelCMS::admin.permissions.create')->with(['roles'=> $roles,'template'=>$this->adminTemplate()]);
        }
        /**
         * Create a new permission instance after a valid registration.
         *
         * @param  array  $data
         * @return Permission
         */
        public function store(Request $r)
        {
            $this->validate($r, [
                'name' => 'required|min:4',
            ]);

            $permission = new Permission($r->all());
            $permission->save();

            $roles = $r['roles'];

            // Save selected tags, if all are deselected , detach all relations else sync selected
            (!is_array($roles)) ? $permission->roles()->detach() : $permission->roles()->sync($roles);

            return redirect()->action('Admin\PermissionsController@index');
        }

        public function edit(Permission $permission)
        {
            $roles = Role::all();
            $currentRoles = $permission->roles->pluck('role_id')->toArray();
            return view('JornSchalkwijk\LaravelCMS::admin.permissions.edit')->with(['permission'=>$permission,'roles' => $roles,'currentRoles'=>$currentRoles,'template' =>$this->adminTemplate()]);
        }
        public function update(Request $r,Permission $permission)
        {

            $this->validate($r, [
                'name' => 'required|min:4',
            ]);

            $permission->update($r->all());

            $roles = $r['roles'];

            // Save selected tags, if all are deselected , detach all relations else sync selected
            (!is_array($roles)) ? $permission->roles()->detach() : $permission->roles()->sync($roles);

            return redirect()->action('Admin\PermissionsController@index');
        }

    }
