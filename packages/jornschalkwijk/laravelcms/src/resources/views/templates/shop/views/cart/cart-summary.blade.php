<h2>Summary</h2>
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
        <a href="{{route('order.index')}}" class="btn btn-md btn-success">Order Details</a>
    </div>
</div>