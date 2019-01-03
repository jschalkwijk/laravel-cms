@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <div class="container">
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
                        @foreach($cart->all() as $item)
                            <tr id="product-{{$item->product_id}}">
                                <td class="align-middle">{{$loop->iteration}}</td>

                                <td class="align-middle"><a
                                            href="{{route('products.show',$item->product_id)}}">{{ $item->name }}</a>
                                </td>
                                <td class="align-middle">{{$item->total()}}</td>
                                <td class="align-middle">{{$item->tax_value}}</td>
                                <td class="align-middle">
                                    {{$item->quantity}}
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

                </div>
            </div>
            <div id="cart-table" class="col-6 col-md-4">
                <h1 class="d-flex justify-content-center">Summary</h1>
                @if(count($cart->all()) != 0)
                    @include('JornSchalkwijk\LaravelCMS::admin.cart.cart-summary')
                @endif
            </div>
        </div>
    </div>
@stop