@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
<div class="container">
    <form action="{{route('order.store')}}" method="post">
        {{method_field('POST')}}
        {{csrf_field()}}
        <div class="row">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Your Details</h3>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}" required>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="create-account" id="create-account" data-toggle='collapse' data-target='#password-field'/>
                            <label for="account">Create Account</label>
                        </div>
                        <div id="password-field" class="collapse form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control"/>
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
                                    <input type="text" name="address1" id="address1" value="{{old('address1')}}" class="form-control">
                                    @if($errors->has('address1'))
                                        <span class="alert alert-warning form-control">{{ $errors->first('address1') }} </span>
                                    @endif
                                    <label for="address2"> Address Line 2</label>
                                    <input type="text" name="address2" id="address2" value="{{old('address2')}}" class="form-control">
                                    <label for="city"> City</label>
                                    <input type="text" name="city" id="city" value="{{old('city')}}" class="form-control" >
                                    @if($errors->has('city'))
                                        <span class="alert alert-warning form-control">{{ $errors->first('city') }} </span>
                                    @endif
                                    <label for="postal"> Postal/Zip</label>
                                    <input type="text" name="postal" id="postal" value="{{old('postal')}}" class="form-control">
                                    @if($errors->has('postal'))
                                        <span class="alert alert-warning form-control">{{ $errors->first('postal') }} </span>
                                    @endif
                                    <input type="checkbox" name="billing_same" id="billing_same" value="{{old('billing_same')}}"/>
                                    <label for="billing-same">Billing address is the same as shipping address</label>
                                </div>
                            </div>
                        </div>
                        <div id="billing" class="row">
                            <div class="col">
                                <h3>Billing Address</h3>
                                <div class="form-group">
                                    <label for="billing_address1">Address Line 1</label>
                                    <input type="text" name="billing_address1" id="billing_address1" value="{{old('billing_address1')}}" class="form-control">
                                    @if($errors->has('billing_address1'))
                                        <span class="alert alert-warning form-control">{{ $errors->first('billing_address1') }} </span>
                                    @endif
                                    <label for="billing_address2"> Address Line 2</label>
                                    <input type="text" name="billing_address2" id="billing_address2" value="{{old('billing_address2')}}" class="form-control">
                                    <label for="billing_city"> City</label>
                                    <input type="text" name="billing_city" id="billing_city" value="{{old('billing_city')}}" class="form-control">
                                    @if($errors->has('billing_city'))
                                        <span class="alert alert-warning form-control">{{ $errors->first('billing_city') }} </span>
                                    @endif
                                    <label for="billing_postal"> Postal/Zip</label>
                                    <input type="text" name="billing_postal" id="billing_postal" value="{{old('billing_postal')}}" class="form-control">
                                    @if($errors->has('billing_postal'))
                                        <span class="alert alert-warning form-control">{{ $errors->first('billing_postal') }} </span>
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
                        <button class="btn btn-default btn-success">Place Order</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@push('scripts')
<script src="{{ asset('/vendor/jornschalkwijk/LaravelCMS/assets/js/shopping/cart/cart.js') }}"></script>
@endpush

@stop