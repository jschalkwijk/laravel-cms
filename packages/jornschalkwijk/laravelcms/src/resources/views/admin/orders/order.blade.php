@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
<div class="container">
    @if(auth()->guard('customer')->user())
        @php
            $route = route('order.store');
        @endphp
        <div class="row">
            <div class="col-md-4">
                <div class="well">
                    @include('JornSchalkwijk\LaravelCMS::admin.cart.cart-summary')
                    <button class="btn btn-default btn-success">Confirm and Pay</button>
                </div>
            </div>
        </div>
    @else
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('customers.login') }}" aria-label="{{ __('Login') }}">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-sm-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    <a class="btn btn-link" href="{{ route('customers.password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{route('customers.register')}}" method="post">
            {{method_field('POST')}}
            {{csrf_field()}}
            <div class="row">
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Your Details</h3>
                            <div class="form-group">
                                <label for="name">First Name</label>
                                <input type="text" name="first_name" id="first_name" class="form-control" value="{{old('first_name')}}">
                                @if($errors->has('first_name'))
                                    <div class="alert alert-warning">{{ $errors->first('first_name') }} </div>
                                @endif
                                <label for="name">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control" value="{{old('last_name')}}">
                                @if($errors->has('last_name'))
                                    <div class="alert alert-warning">{{ $errors->first('last_name') }} </div>
                                @endif
                                <label for="email">E-Mail</label>
                                <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                                @if($errors->has('email'))
                                    <div class="alert alert-warning">{{ $errors->first('email') }} </div>
                                @endif
                                <label for="email">Phone</label>
                                <input type="tel" name="phone_1" id="phone_1" class="form-control" value="{{old('phone_1')}}">
                                @if($errors->has('phone_1'))
                                    <div class="alert alert-warning">{{ $errors->first('phone_1') }} </div>
                                @endif
                                <label for="email">Date of Birth</label>
                                <input type="date" name="dob" id="dob" class="form-control" value="{{old('dob')}}">
                                @if($errors->has('dob'))
                                    <div class="alert alert-warning">{{ $errors->first('dob') }} </div>
                                @endif
                            </div>
                            <div id="password-field" class="form-group">
                                <label for="password">Password  </label>
                                <input type="password" name="password" id="password" class="form-control"/>
                                @if($errors->has('password'))
                                    <div class="alert alert-warning">{{ $errors->first('password') }} </div>
                                @endif
                                <label for="password_confirmation">Password Again</label>
                                <input type="password" name="password_confirmation" id="password-again" class="form-control"/>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col">
                                    <h3>Shipping Address</h3>
                                    <div class="form-group">
                                        <label for="address1"> Address Line 1</label>
                                        <input type="text" name="address_1" id="address_1" value="{{old('address_1')}}" class="form-control">
                                        @if($errors->has('address_1'))
                                            <div class="alert alert-warning">{{ $errors->first('address_1') }} </div>
                                        @endif
                                        <label for="address2"> Address Line 2</label>
                                        <input type="text" name="address_2" id="address_2" value="{{old('address_2')}}" class="form-control">
                                        <label for="city"> City</label>
                                        <input type="text" name="city" id="city" value="{{old('city')}}" class="form-control" >
                                        @if($errors->has('city'))
                                            <div class="alert alert-warning">{{ $errors->first('city') }} </div>
                                        @endif
                                        <label for="postal"> Postal/Zip</label>
                                        <input type="text" name="postal" id="postal" value="{{old('postal')}}" class="form-control">
                                        @if($errors->has('postal'))
                                            <div class="alert alert-warning">{{ $errors->first('postal') }} </div>
                                        @endif
                                        {{--<input type="checkbox" name="billing_same" id="billing_same" value="{{1}}" @if(old('billing_same') === '1') checked @endif/>--}}
                                        {{--<label for="billing-same">Billing address is the same as shipping address</label>--}}
                                        <div class="form-group">
                                            <input type="checkbox" name="billing_same" id="billing_same" value="{{1}}" @if(old('billing_same') === '1') checked @endif data-toggle='collapse' data-target='#billing' aria-expanded="false" aria-controls="billing"/>
                                            <label for="billing-same">Billing address is the same as shipping address</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="billing" class="collapse @if(old('billing_same') === '1') hide @else show @endif row">
                                <div class="col">
                                    <h3>Billing Address</h3>
                                    <div class="form-group">
                                        <label for="billing_address1">Address Line 1</label>
                                        <input type="text" name="billing_address_1" id="billing_address_1" value="{{old('billing_address_1')}}" class="form-control">
                                        @if($errors->has('billing_address_1'))
                                            <div class="alert alert-warning">{{ $errors->first('billing_address_1') }} </div>
                                        @endif
                                        <label for="billing_address2"> Address Line 2</label>
                                        <input type="text" name="billing_address_2" id="billing_address_2" value="{{old('billing_address_2')}}" class="form-control">
                                        <label for="billing_city"> City</label>
                                        <input type="text" name="billing_city" id="billing_city" value="{{old('billing_city')}}" class="form-control">
                                        @if($errors->has('billing_city'))
                                            <div class="alert alert-warning">{{ $errors->first('billing_city') }} </div>
                                        @endif
                                        <label for="billing_postal"> Postal/Zip</label>
                                        <input type="text" name="billing_postal" id="billing_postal" value="{{old('billing_postal')}}" class="form-control">
                                        @if($errors->has('billing_postal'))
                                            <div class="alert alert-warning">{{ $errors->first('billing_postal') }} </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<pre>--}}
                {{--@php(print_r(\Illuminate\Support\Facades\Session::all()))--}}

                {{--</pre>--}}
                <div class="col-md-4">
                    <div class="row">
                        <div class="well">
                            @include('JornSchalkwijk\LaravelCMS::admin.orders.order-summary')
                            @include('JornSchalkwijk\LaravelCMS::admin.cart.cart-summary')
                            <button class="btn btn-default btn-success">Create Account</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
</div>
@push('scripts')
    <script src="{{ asset('/vendor/jornschalkwijk/LaravelCMS/assets/js/shopping/cart/cart.js') }}"></script>
@endpush

@stop