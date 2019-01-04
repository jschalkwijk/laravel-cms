@if(count($cart->all()) != 0)
    <a href="{{route('cart.empty')}}" id="empty" class="btn btn-sm btn-danger">Empty Cart</a>
@endif
<h2>Summary</h2>
@if(Session::has('refreshed'))
    @foreach(Session::get('refreshed') as $product)
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <p class="alert alert-warning">{{$product}}</p>
            <span class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </span>
        </div>
    @endforeach
        @php(Session::forget('refreshed'))
@endif
<ul class="summary-table">
    <li><span>quantity</span> <span>{{$cart->totalQuantity()}}</span></li>
    <li><span>shipping:</span> <span>€ {{$cart->shipping}}</span></li>
    <li><span>discount:</span> <span>0%</span></li>
    <li><span>total:</span> <span class="alert-success">€ {{$cart->total()}}</span></li>
</ul>
<div class="checkout-btn mt-100">
    <div class="d-flex justify-content-center">
        <a href="{{route('cart.refresh')}}" id="refresh" class="btn btn-sm btn-info">Refresh</a>
    </div>

    <div class="d-flex justify-content-center">
        <a href="{{route('order.index')}}" class="btn btn-md btn-success">Checkout</a>
    </div>
</div>