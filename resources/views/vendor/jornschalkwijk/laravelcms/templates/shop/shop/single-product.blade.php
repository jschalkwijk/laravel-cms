<!-- Single Product -->
<div class="col-12 col-sm-6 col-lg-4">
    <div class="single-product-wrapper">
        <!-- Product Image -->
        <div class="product-img">
            @if($product->getFeatured() !== null)
            <img src="{{ asset('/storage/'.$product->getFeatured()->path('medium')) }}"/>
                <!-- Hover Thumb -->
                <img class="hover-img" src="{{ asset('/storage/'.$product->getFeatured()->path('medium')) }}" alt="">
            @else
                    <img src="#"/>
                <img class="hover-img" src="#" alt="">
            @endif

            <!-- Product Badge -->
            @if($product->discount_percentage > 0)
                <div class="product-badge offer-badge">
                    <span>-{{$product->discount_percentage}}%</span>
                </div>
            @endif
            <!-- Favourite -->
            <div class="product-favourite">
                <a href="#" class="favme fa fa-heart"></a>
            </div>
        </div>

        <!-- Product Description -->
        <div class="product-description">
            <span>Brand Name</span>
            <a href="../single-product-details.blade.php">
                <h6>{{$product->name}}</h6>
            </a>
            <p class="product-price">
                @if($product->discount_percentage > 0)
                     <span class="old-price"> € {{$product->price}}</span> € {{$product->discount_price}}
                @else
                    € {{$product->price}}
                @endif
            </p>

            <!-- Hover Content -->
            <div class="hover-content">
                <div class="add-to-cart-btn">
                    <form method="post" action="{{route('cart.update')}}">
                        {{ csrf_field() }}
                        <input type="hidden" name="product_id" value="{{$product->product_id}}">
                        <input type="hidden" name="quantity" value="{{ ($product->stock - 1 != 0) ? 1 : 0 }}">

                        <button type="submit" class="btn template-btn">Add to Cart</button>

                    </form>
                </div>
                {{--<!-- Add to Cart -->--}}
                {{--<div class="add-to-cart-btn">--}}
                    {{--<a href="#" class="btn template-btn">Add to Cart</a>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
</div>