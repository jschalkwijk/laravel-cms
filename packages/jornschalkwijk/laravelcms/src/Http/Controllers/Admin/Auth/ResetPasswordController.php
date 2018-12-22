<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Auth;
use JornSchalkwijk\LaravelCMS\Http\Controllers\Admin\Controller;

use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;
    // overwrite trait function to set right admin view path
    public function showResetForm(Request $request, $token = null)
    {
        return view('JornSchalkwijk\LaravelCMS::admin.auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
}
