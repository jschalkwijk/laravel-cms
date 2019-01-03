@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <div class="container">
        {{  Auth::guard('customer')->user()}}
        <div class="row">
            <div class="col-md">
                <h1>Order</h1>
                <table id="cart-table" class="table table-sm table-striped">
                    <thead class="thead-default">
                    <th>#</th>
                    <th>Product</th>
                    <th>Price (inc. tax)</th>
                    <th>Tax</th>
                    <th>Quantity</th>
                    <th>Total Tax</th>
                    <th>Total</th>
                    </thead>
                    <tbody id="cart">
                    @foreach($order->products as $order)
                        <tr id="product-{{$order->product_id}}">
                            <td class="align-middle">{{$loop->iteration}}</td>

                            <td class="align-middle"><a
                                        href="{{route('products.show',$order->product_id)}}">{{ $order->name }}</a></td>
                            <td class="align-middle">{{$order->total()}}</td>
                            <td class="align-middle">{{$order->tax_value}}</td>
                            <td class="align-middle">
                                <form method="post" action="{{route('cart.update')}}">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="product_id" value="{{$order->product_id}}">
                                    <select name="quantity" class="quantity" disabled="true">
                                        @for($i = 0; $i < $order->stock+1; $i++)
                                            @if($i == $order->getQuantity())
                                                <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                                            @else
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endif
                                        @endfor
                                    </select>
                                    <button type="submit" class="update">Update</button>
                                </form>
                            </td>
                            <td class="align-middle">{{$order->tax_value * $order->getQuantity()}}</td>
                            <td class="align-middle">{{$order->productTotal()}}</td>
                        </tr>
                        @if(Session::has($order->product_id))
                            <tr class="alert alert-warning alert-dismissible fade show" role="alert">
                                <td colspan="7" class="alert alert-warning">{{Session::get($order->product_id) }}</td>
                                <td colspan="1">
    <span class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
    </span>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    <a href="{{route('order.index')}}" class="btn btn-md btn-success">Payment</a>
                </div>

            </div>
            {{--<div id="cart-table" class="col-6 col-md-4">--}}
                {{--<h1 class="d-flex justify-content-center">Summary</h1>--}}
                {{--@if(count($cart->all()) != 0)--}}
                    {{--@include('JornSchalkwijk\LaravelCMS::admin.cart.cart-summary')--}}
                {{--@endif--}}
            {{--</div>--}}
        </div>

    </div>
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
        action="{{route('payment.paypal',$order->hash)}}">
        {{method_field('POST')}}
        {{ csrf_field() }}
        <button class="w3-btn w3-blue">Pay with PayPal</button>
        </form>

    </div>
@stop