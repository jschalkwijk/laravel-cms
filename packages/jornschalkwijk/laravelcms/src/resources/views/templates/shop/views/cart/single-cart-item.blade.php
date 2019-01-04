<div class="single-cart-item">
    <div class="product-image">
        <img src="/vendor/jornschalkwijk/LaravelCMS/templates/shop/img/product-img/product-1.jpg" class="cart-thumb" alt="">
        <!-- Cart Item Desc -->
        <div class="cart-item-desc">
            <a href="{{route('cart.destroy',$product->product_id)}}" class="remove product-remove">
               <i class="fa fa-close" aria-hidden="true"></i>
            </a>
            <h6><a href="{{route('products.show',$product->product_id)}}">{{ $product->name }}</a></h6>
            <p class="cart-item-size">Size: S</p>
            <p class="cart-item-color">Color: Red</p>
            <p class="cart-item-price">€ {{$product->total()}}</p>
            <div><form method="post" action="{{route('cart.update')}}">
                {{ csrf_field() }}
                <input type="hidden" name="product_id" value="{{$product->product_id}}">
                <select name="quantity" class="quantity" style="padding: 5px 0 15px 0;">
                    @for($i = 0; $i < $product->stock+1; $i++)
                        @if($i == $product->getQuantity())
                            <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                        @else
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endif
                    @endfor
                </select>
            </form>
            </div>
            <br>
            <p class="cart-price"> € {{$product->productTotal()}}</p>
        </div>
    </div>
</div>