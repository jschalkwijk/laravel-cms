@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-6 col-sm-offset-3 push-lg-3">
                <h1 class="d-flex justify-content-center">Cart</h1>
                <div class="d-flex justify-content-center">

                    <form action="#" method="post">
                        <table class="table table-sm table-striped">
                            <thead class="thead-default">
                            <th>#</th>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Tax</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th></th>
                            </thead>
                            @foreach($cart->all() as $product)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$product->name}}</td>
                                    <td>{{$product->total()}}</td>
                                    <td>{{$product->tax_value}}</td>
                                    <td>{{$product->quantity}}</td>
                                    <td>{{$product->productTotal()}}</td>
                                    <td><a href="#" class="form-action btn btn-sm btn-danger">X</a></td>
                                </tr>
                            @endforeach
                            <tr><td></td><td></td><td></td><td>{{$cart->totalTax}}</td><td>{{$cart->totalQuantity()}}</td><td>{{$cart->subTotal()}}</td></tr>
                        </table>
                    </form>

                </div>
                <div class="d-flex justify-content-center">
                    <button>Place Order</button>
                </div>
            </div>
        </div>
    </div>
@stop