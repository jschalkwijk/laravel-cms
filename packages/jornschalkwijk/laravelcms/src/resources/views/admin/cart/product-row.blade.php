@section('content')
    @foreach($cart->all() as $product)
        <tr id="product-{{$product->product_id}}">
            <td class="align-middle">{{$loop->iteration}}</td>

            <td class="align-middle"><a href="{{route('products.show',$product->product_id)}}">{{ $product->name }}</a></td>
            <td class="align-middle">{{$product->total()}}</td>
            <td class="align-middle">{{$product->tax_value}}</td>f
            <td class="align-middle">
                <form method="post" action="{{route('cart.update')}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="{{$product->product_id}}">
                    <select name="quantity" class="quantity">
                        @for($i = 0; $i < $product->maxStock()+1; $i++)
                            @if($i == $product->getQuantity())
                                <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                    <button class="update" type="submit">Update</button>
                </form>
            </td>
            <td>{{$product->tax_value * $product->getQuantity()}}</td>
            <td class="align-middle">{{$product->productTotal()}}</td>
            <td class="align-middle"><a href="{{route('cart.destroy',$product->product_id)}}" class="form-action btn btn-sm btn-danger">X</a></td>
        </tr>
    @endforeach
    <tr style="height: 15px !important"></tr>
    <tr><td></td><td></td><td></td><td>{{$cart->totalTax}}</td><td>{{$cart->totalQuantity()}}</td><td>total tax</td><td>{{$cart->subTotal()}}</td></tr>

@stop