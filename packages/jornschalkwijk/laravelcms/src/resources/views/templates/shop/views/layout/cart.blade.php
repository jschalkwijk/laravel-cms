<!-- ##### Right Side Cart Area ##### -->
<div class="cart-bg-overlay"></div>

<div class="right-side-cart-area">

    <!-- Cart Button -->
    <div class="cart-button">
        <a href="#" id="rightSideCart"><img src="/vendor/jornschalkwijk/LaravelCMS/templates/shop/img/cart/bag.svg" alt=""> <span>{{$cart->itemCount()}}</span></a>
    </div>

    <div id="cart-content" class="cart-content d-flex">

       @include('vendor.jornschalkwijk.laravelcms.templates.shop.cart.cart-content')
    </div>
</div>

@push('scripts')
<script src="{{ asset('/vendor/jornschalkwijk/LaravelCMS/templates/shop/js/shopping/cart/cart.js') }}"></script>
@endpush

<!-- ##### Right Side Cart End ##### -->