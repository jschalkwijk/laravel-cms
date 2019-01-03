<?php

namespace JornSchalkwijk\LaravelCMS\Http\Controllers\Customers\Auth;

use JornSchalkwijk\LaravelCMS\Models\Customer;
use Illuminate\Support\Facades\Validator;
use CMS\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use JornSchalkwijk\LaravelCMS\Models\Address;

class CustomerRegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

//    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make(
            $data,
            $rules = [
                'first_name'         => [
                    'required', 'regex:/^[\pL\s\-]+$/u', 'max:255',
                ],
                'last_name'         => [
                    'required', 'regex:/^[\pL\s\-]+$/u', 'max:255',
                ],
                'email'        => [
                    'required', 'email', 'max:255',
                    Rule::unique('customers'),
                ],
                'password'     => 'min:8|alpha_num|confirmed',
                'address_1'     => 'required|min:3|regex:/^[a-zA-Z\d\-\s]+$/i',
                'address_2'     => 'min:3|regex:/^[a-zA-Z\d\-\s]+$/i',
                'postal'       => 'required|min:3|alpha_num',
                'city'         => 'required|min:3|alpha',
                'billing_address_1' => 'required_without:billing_same|min:3|regex:/^[a-zA-Z\d\-\s]+$/i',
                'billing_address_2' => 'min:3|regex:/^[a-zA-Z\d\-\s]+$/i',
                'billing_postal' => 'required_without:billing_same|min:3|regex:/^[a-zA-Z\d\-\s]+$/i',
                'billing_city' => 'required_without:billing_same|min:3|alpha',
            ]
        );
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  $data
     * @return Customer
     */
    protected function create($data)
    {
        // remove product stock

        $address = Address::firstOrCreate([['address_1', '=', $data['address_1']],['address_2', '=', $data['address_2']],['postal', '=', $data['postal']],['city','=',$data['city']]])->get();

        // Create Customer

        $customer = new Customer();
        $customer->first_name = $data['first_name'];
        $customer->last_name = $data['last_name'];
        $customer->email = $data['email'];
        $customer->password = bcrypt($data['password']);
        $customer->phone_1 = $data['phone_1'];
//        $customer->phone_2 = $data['phone_2'];
        $customer->dob = $data['dob'];

        $customer->save();

        // After saving update the customer and address tables with the saved id
        $customer->addresses()->attach([$address->address_id => ['type' => 'primary']]);

        return $customer;
    }
    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        return view('JornSchalkwijk\LaravelCMS::customers.auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($customer = $this->create($request)));

        $this->guard()->login($customer);

        return $this->registered($request, $customer)
            ?: redirect($this->redirectTo);
    }
    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerFromOrder(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($customer = $this->create($request->all())));

        Auth::guard('customer')->login($customer);

        return $this->registered($request, $customer) ?: redirect(route('order.confirm'));
    }



    /**
     * Get the guard to be used during registration.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * The user has been registered.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function registered(Request $request, $user)
    {
        return redirect(route('order.confirm'));
    }
}
