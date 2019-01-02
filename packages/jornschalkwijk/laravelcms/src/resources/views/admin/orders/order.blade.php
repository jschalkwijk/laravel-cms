@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
<div class="container">
    <form action="{{route('order.store')}}" method="post">
        {{method_field('POST')}}k
        {{csrf_field()}}
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Your Details</h3>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{old('name')}}">
                            @if($errors->has('name'))
                                <div class="alert alert-warning">{{ $errors->first('name') }} </div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{old('email')}}">
                            @if($errors->has('email'))
                                <div class="alert alert-warning">{{ $errors->first('email') }} </div>
                            @endif
                        </div>
                        <div class="form-group">
                            {{--<input type="checkbox" name="create-account" id="create-account"/>--}}
                            <input type="checkbox" name="create-account" id="create-account" value="1" data-toggle='collapse' data-target='#password-field' @if(old('create-account') === '1') checked @endif/>
                            <label for="create-account">Create Account</label>
                        </div>
                        <div id="password-field" class="collapse @if(old('create-account') === '1') show @else hide @endif form-group">
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
                                    <input type="text" name="address1" id="address1" value="{{old('address1')}}" class="form-control">
                                    @if($errors->has('address1'))
                                        <div class="alert alert-warning">{{ $errors->first('address1') }} </div>
                                    @endif
                                    <label for="address2"> Address Line 2</label>
                                    <input type="text" name="address2" id="address2" value="{{old('address2')}}" class="form-control">
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
                                    <input type="text" name="billing_address1" id="billing_address1" value="{{old('billing_address1')}}" class="form-control">
                                    @if($errors->has('billing_address1'))
                                        <div class="alert alert-warning">{{ $errors->first('billing_address1') }} </div>
                                    @endif
                                    <label for="billing_address2"> Address Line 2</label>
                                    <input type="text" name="billing_address2" id="billing_address2" value="{{old('billing_address2')}}" class="form-control">
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