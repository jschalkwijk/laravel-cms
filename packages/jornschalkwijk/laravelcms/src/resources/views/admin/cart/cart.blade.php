@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-6 col-sm-offset-3 push-lg-3">
                <h1 class="d-flex justify-content-center">Cart</h1>
                <div class="d-flex justify-content-center">
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
                                <td class="align-middle">{{$loop->iteration}}</td>
                                <td class="align-middle"><a href="{{route('products.show',$product->product_id)}}">{{ $product->name }}</a></td>
                                <td class="align-middle">{{$product->total()}}</td>
                                <td class="align-middle">{{$product->tax_value}}</td>
                                <td class="align-middle">
                                    <form method="post" action="#">
                                        <select name="quantity">
                                            @for($i = 0; $i < $product->maxStock()+1; $i++)
                                                @if($i == $product->getQuantity())
                                                    <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                                                @else
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endif
                                            @endfor
                                        </select>
                                    </form>
                                </td>
                                <td class="align-middle">{{$product->productTotal()}}</td>
                                <td class="align-middle"><a href="#" class="form-action btn btn-sm btn-danger">X</a></td>
                            </tr>
                        @endforeach
                        <tr style="height: 15px !important"></tr>
                        <tr><td></td><td></td><td></td><td>{{$cart->totalTax}}</td><td>{{$cart->totalQuantity()}}</td><td>{{$cart->subTotal()}}</td></tr>
                    </table>
                </div>
                <div class="d-flex justify-content-center">
                    <button>Place Order</button>
                </div>
            </div>
        </div>
    </div>
@stop