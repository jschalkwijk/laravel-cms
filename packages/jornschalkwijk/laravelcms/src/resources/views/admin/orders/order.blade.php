@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
<div class="container">
    <form action="#" method="post">
        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6">
                        <h3>Your Details</h3>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-Mail</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="create-account" id="create-account" data-toggle='collapse' data-target='#password-field'/>
                            <label for="account">Create Account</label>
                        </div>
                        <div id="password-field" class="collapse form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control"/>
                            <label for="password-again">Password Again</label>
                            <input type="password" name="password-again" id="password-again" class="form-control"/>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col">
                                <h3>Shipping Address</h3>
                                <div class="form-group">
                                    <label for="address1"> Address Line 1</label>
                                    <input type="text" name="address1" id="address1" class="form-control" required>
                                    <label for="address2"> Address Line 2</label>
                                    <input type="text" name="address2" id="address2" class="form-control">
                                    <label for="city"> City</label>
                                    <input type="text" name="city" id="city" class="form-control" required>
                                    <label for="postal"> Postal/Zip</label>
                                    <input type="text" name="postal" id="postal" class="form-control" required>
                                    <input type="checkbox" name="billing-same" id="billing-same"/>
                                    <label for="billing-same">Billing address is the same as shipping address</label>
                                </div>
                            </div>
                        </div>
                        <div id="billing" class="row">
                            <div class="col">
                                <h3>Billing Address</h3>
                                <div class="form-group">
                                    <label for="billing_address1">Address Line 1</label>
                                    <input type="text" name="billing_address1" id="billing_address1" class="form-control">
                                    <label for="billing_address2"> Address Line 2</label>
                                    <input type="text" name="billing_address2" id="billing_address2" class="form-control">
                                    <label for="billing_city"> City</label>
                                    <input type="text" name="billing_city" id="billing_city" class="form-control">
                                    <label for="billing_postal"> Postal/Zip</label>
                                    <input type="text" name="billing_postal" id="billing_postal" class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    <div class="row">

        @if ($message = Session::get('success'))
            <div class="w3-panel w3-green w3-display-container">
                <span onclick="this.parentElement.style.display='none'" class="w3-button w3-green w3-large w3-display-topright">&times;</span>
                <p>{!! $message !!}</p>
            </div>
            <?php Session::forget('success');?>
        @endif

        @if ($message = Session::get('error'))
            <div class="w3-panel w3-red w3-display-container">
            <span onclick="this.parentElement.style.display='none'"
                  class="w3-button w3-red w3-large w3-display-topright">&times;</span>
                <p>{!! $message !!}</p>
            </div>
            <?php Session::forget('error');?>
        @endif

        <form class="w3-container w3-display-middle w3-card-4 w3-padding-16" method="POST" id="payment-form"
              action="{{route('payment.paypal')}}">
            {{method_field('POST')}}
            {{ csrf_field() }}
            <button class="w3-btn w3-blue">Pay with PayPal</button>
        </form>

    </div>
</div>
@push('scripts')
<script src="{{ asset('/vendor/jornschalkwijk/LaravelCMS/assets/js/shopping/cart/cart.js') }}"></script>
@endpush
{{--<div class="container">--}}
    {{--<div class="row">--}}
        {{--<div class="col-md">--}}
            {{--<h1>Order</h1>--}}
            {{--<table id="cart-table" class="table table-sm table-striped">--}}
                {{--<thead class="thead-default">--}}
                    {{--<th>#</th>--}}
                    {{--<th>Product</th>--}}
                    {{--<th>Price (inc. tax)</th>--}}
                    {{--<th>Tax</th>--}}
                    {{--<th>Quantity</th>--}}
                    {{--<th>Total Tax</th>--}}
                    {{--<th>Total</th>--}}
                {{--</thead>--}}
                {{--<tbody id="cart">--}}
                {{--@foreach($cart->all() as $order)--}}
                    {{--<tr id="product-{{$order->product_id}}">--}}
                        {{--<td class="align-middle">{{$loop->iteration}}</td>--}}

                        {{--<td class="align-middle"><a href="{{route('products.show',$order->product_id)}}">{{ $order->name }}</a></td>--}}
                        {{--<td class="align-middle">{{$order->total()}}</td>--}}
                        {{--<td class="align-middle">{{$order->tax_value}}</td>--}}
                        {{--<td class="align-middle">--}}
                            {{--<form method="post" action="{{route('cart.update')}}">--}}
                                {{--{{ csrf_field() }}--}}
                                {{--<input type="hidden" name="product_id" value="{{$order->product_id}}">--}}
                                {{--<select name="quantity" class="quantity" disabled="true">--}}
                                    {{--@for($i = 0; $i < $order->stock+1; $i++)--}}
                                        {{--@if($i == $order->getQuantity())--}}
                                            {{--<option value="{{ $i }}" selected="selected">{{ $i }}</option>--}}
                                        {{--@else--}}
                                            {{--<option value="{{ $i }}">{{ $i }}</option>--}}
                                        {{--@endif--}}
                                    {{--@endfor--}}
                                {{--</select>--}}
                                {{--<button type="submit" class="update">Update</button>--}}
                            {{--</form>--}}
                        {{--</td>--}}
                        {{--<td class="align-middle">{{$order->tax_value * $order->getQuantity()}}</td>--}}
                        {{--<td class="align-middle">{{$order->productTotal()}}</td>--}}
                    {{--</tr>--}}
                    {{--@if(Session::has($order->product_id))--}}
                        {{--<tr class="alert alert-warning alert-dismissible fade show" role="alert">--}}
                            {{--<td colspan="7" class="alert alert-warning">{{Session::get($order->product_id) }}</td>--}}
                            {{--<td colspan="1">--}}
                {{--<span class="close" data-dismiss="alert" aria-label="Close">--}}
                    {{--<span aria-hidden="true">&times;</span>--}}
                {{--</span>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                    {{--@endif--}}
                {{--@endforeach--}}
                {{--</tbody>--}}
            {{--</table>--}}

            {{--<div class="d-flex justify-content-center">--}}
                {{--<a href="{{route('order.index')}}" class="btn btn-md btn-success">Payment</a>--}}
            {{--</div>--}}

        {{--</div>--}}
        {{--<div id="cart-table" class="col-6 col-md-4">--}}
            {{--<h1 class="d-flex justify-content-center">Summary</h1>--}}
            {{--@if(count($cart->all()) != 0)--}}
                {{--@include('JornSchalkwijk\LaravelCMS::admin.cart.cart-summary')--}}
            {{--@endif--}}
        {{--</div>--}}
    {{--</div>--}}

{{--</div>--}}

@stop