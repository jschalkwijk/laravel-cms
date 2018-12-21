<div id="cart">
    <h4>Your Order</h4>
    <table class="table">
        <thead>
        <th>Product</th>
        <th>Quantity</th>
        </thead>
        <tbody>
        @foreach($cart->all() as $product)
            <tr>
                <td>{{$product->name}}</td>
                <td>{{$product->quantity}}</td>
            </tr>
            @if(Session::has($product->product_id))
                <tr class="alert alert-warning alert-dismissible fade show" role="alert">
                    <td colspan="7" class="alert alert-warning">{{Session::get($product->product_id) }}</td>
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
