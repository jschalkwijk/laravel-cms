<!-- ##### Right Side Cart Area ##### -->
<div class="cart-bg-overlay"></div>

<div class="right-side-cart-area">

    <!-- Cart Button -->
    <div class="cart-button">
        <a href="#" id="rightSideCart"><img src="/vendor/jornschalkwijk/LaravelCMS/templates/shop/img/cart/bag.svg" alt=""> <span>{{$cart->itemCount()}}</span></a>
    </div>

    <div class="cart-content d-flex">

        <!-- Cart List Area -->
        <div id="cart" class="cart-list">
            @each(  'vendor.jornschalkwijk.laravelcms.templates.shop.cart.single-cart-item',$cart->all(), 'product')
        </div>
        <div id="cart-summary" class="cart-amount-summary">
            @if(count($cart->all()) != 0)
                @include('vendor.jornschalkwijk.laravelcms.templates.shop.cart.cart-summary')
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('/vendor/jornschalkwijk/LaravelCMS/templates/shop/js/shopping/cart/cart.js') }}"></script>
@end

<!-- ##### Right Side Cart End ##### -->