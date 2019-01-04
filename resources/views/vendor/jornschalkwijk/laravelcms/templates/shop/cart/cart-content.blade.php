<!-- Cart List Area -->
<div id="cart" class="cart-list">
    @each(  'vendor.jornschalkwijk.laravelcms.templates.shop.cart.single-cart-item',$cart->all(), 'product')
</div>
<div id="cart-summary" class="cart-amount-summary">
    @if(count($cart->all()) != 0)
        @include('vendor.jornschalkwijk.laravelcms.templates.shop.cart.cart-summary')
    @else
        <p>Go <a href="{{route('shop.index')}}">shopping</a>!</p>
    @endif
</div>