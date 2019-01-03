@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <div class="container">
        {{  Auth::guard('customer')->user()}}
        <div class="row">
            <div class="col-md">
                <div class="row">
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
                        @foreach($order->products as $item)
                            <tr id="product-{{$item->product_id}}">
                                <td class="align-middle">{{$loop->iteration}}</td>

                                <td class="align-middle"><a
                                            href="{{route('products.show',$item->product_id)}}">{{ $item->name }}</a>
                                </td>
                                <td class="align-middle">{{$item->total()}}</td>
                                <td class="align-middle">{{$item->tax_value}}</td>
                                <td class="align-middle">
                                    {{$item->pivot->quantity}}
                                </td>
                                <td class="align-middle">{{$item->tax_value * $item->pivot->quantity}}</td>
                                <td class="align-middle">{{$item->pivot->quantity * $item->total()}}</td>
                            </tr>
                            @if(Session::has($item->product_id))
                                <tr class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <td colspan="7"
                                        class="alert alert-warning">{{Session::get($item->product_id) }}</td>
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

                    @if (!$order->paid)
                        <form class="w3-container w3-display-middle w3-card-4 w3-padding-16" method="POST" id="payment-form"
                              action="{{route('payment.paypal',[$order->hash])}}">
                            {{method_field('POST')}}
                            {{ csrf_field() }}
                            <button class="w3-btn w3-blue">Pay with PayPal</button>
                        </form>
                    @else
                        <div class="alert alert-success">
                            You have paid this order.
                        </div>
                    @endif

                </div>
            </div>
            {{--<div id="cart-table" class="col-6 col-md-4">--}}
                {{--<h1 class="d-flex justify-content-center">Summary</h1>--}}
                {{--@if(count($order->products) != 0)--}}
                    {{--@include('JornSchalkwijk\LaravelCMS::admin.orders.order-summary')--}}
                {{--@endif--}}
            {{--</div>--}}
        </div>
    </div>
@stop