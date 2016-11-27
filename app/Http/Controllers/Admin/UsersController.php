<?php

namespace CMS\Http\Controllers\Admin;

use CMS\User;
use Illuminate\Http\Request;

use CMS\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $users = User::all();
        return view('admin.users.users')->with(
        [
            'users' => $users,
            'template' => $this->adminTemplate()
        ]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    public function add(Request $r)
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
