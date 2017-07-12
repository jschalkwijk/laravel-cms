<?php

namespace CMS\Http\Controllers\Admin;

use CMS\Models\User;
use CMS\Models\UserActions;
use Illuminate\Http\Request;
use CMS\Models\Action;

use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    use UserActions;
    protected $user;
    protected $permissions;

    public function index()
    {
        foreach(Auth::user()->permission as $perm){
            $this->permissions[] = $perm->name;
        };

        if(!in_array("Create Post",$this->permissions)){ return "not allowed"; }
        $users = User::with('created_by','permission')->where('users.trashed',0)->orderBy('user_id','desc')->get();

        return view('admin.users.users')->with(
        [
            'users' => $users,
            'trashed' => 0,
            'template' => $this->adminTemplate()
        ]);
    }

    public function deleted()
    {
        $users = User::with('created_by')->where('users.trashed',1)->orderBy('user_id','desc')->get();
        return view('admin.users.users')->with(
            [
                'users' => $users,
                'trashed' => 1,
                'template' => $this->adminTemplate()
            ]);
    }
    public function create()
    {
        return view('admin.users.create')->with(['template'=>$this->adminTemplate()]);
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

        $user = User::create([
            'username' => $r['username'],
            'password' => bcrypt($r['password']),
            'email' => $r['email'],
            'first_name' =>$r['first_name'],
            'last_name' => $r['last_name'],
            'dob' => $r['dob'],
            'function' => $r['function'],
            'rights' => $r['rights'],
            'created_by' => Auth::user()->user_id,
        ]);

        event(new Registered($user));

        return redirect()->action('Admin\AdminController@index');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit')->with(['user'=>$user,'template' =>$this->adminTemplate()]);
    }
    public function update(Request $r,User $user)
    {
        $this->validator($r->all())->validate();

        $user->updated_by = Auth::user()->user_id;
        $user->update($r->all());

        return redirect()->action('Admin\UsersController@index');
    }

    public function action(Request $r)
    {
        $this->Actions(new User(),$r);
        return back();
    }

    public function destroy($id)
    {
        $users = User::findOrFail($id);
        User::destroy($users->id());

        return back();
    }

    public function hide($id)
    {
        Action::hide(new User(),$id);
        return back();
    }

    public function approve($id)
    {
        Action::approve(new User(),$id);
        return back();
    }

    public function trash($id)
    {
        Action::trash(new User(),$id);
        return back();
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|alpha_num|confirmed',
            'rights' => 'required',
            'first_name' => 'alpha',
            'last_name' => 'alpha',
            'dob' => 'date',
            'function' => 'alpha',
        ]);
    }

}
