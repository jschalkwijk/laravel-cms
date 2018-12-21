@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-6 col-sm-offset-3 push-lg-3">
                <h1 class="d-flex justify-content-center">Cart</h1>
                <div id="errors">

                </div>
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
                        <button class="btn btn-md btn-success">Place Order</button>
                    </div>
                </div>

            </div>
        </div>

    </div>
    @push('scripts')
    <script src="{{ asset('/vendor/jornschalkwijk/LaravelCMS/assets/js/shopping/cart/cart.js') }}"></script>
    @endpush
@stop