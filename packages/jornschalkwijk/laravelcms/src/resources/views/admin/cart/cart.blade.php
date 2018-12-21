@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md">
                <h1 class="d-flex justify-content-center">Cart</h1>
                <table id="cart-table" class="table table-sm table-striped">
                    <thead class="thead-default">
                    <th>#</th>
                    <th>Product</th>
                    <th>Price (inc. tax)</th>
                    <th>Tax</th>
                    <th>Quantity</th>
                    <th>Total Tax</th>
                    <th>Total</th>
                    <th>
                        @if(count($cart->all()) != 0)
                            <a href="{{route('cart.empty')}}" id="empty" class="btn btn-sm btn-danger">Empty Cart</a>
                        @endif
                    </th>
                    </thead>
                    <tbody id="cart">
                        @include('JornSchalkwijk\LaravelCMS::admin.cart.cart-content')
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    <a href="{{route('cart.refresh')}}" id="refresh" class="btn btn-sm btn-info">Refresh</a>
                </div>

                <div class="d-flex justify-content-center">
                        <a href="{{route('order.index')}}" class="btn btn-md btn-success">Order Details</a>
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
    @push('scripts')
    <script src="{{ asset('/vendor/jornschalkwijk/LaravelCMS/assets/js/shopping/cart/cart.js') }}"></script>
    @endpush
@stop