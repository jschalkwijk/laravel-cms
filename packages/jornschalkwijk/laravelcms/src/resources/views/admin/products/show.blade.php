@extends('JornSchalkwijk\LaravelCMS::admin.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-6 col-sm-offset-3 push-lg-3">
              <div class="d-flex justify-content-center">  <form class="dropzone" id="dropzone" enctype="multipart/form-data" method="post" action="{{ route('uploads.store') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="reload" value="{{(isset($reload)) ? $reload : true }}"/>
                    <input type="hidden" name="destination" value="{{$product->folder_id}}">
                    <div class="fallback">
                        <input type="hidden" name="MAX_FILE_SIZE" value="43500000"/>
                        <label for="files[]" class="form-check-label">Choose File(max size: 3.5 MB): </label><br/>
                        <input type="file" class="form-control" name="files[]" multiple/><br/>
                        <button type="submit" class="form-control" name="submit">Add File('s)</button>
                    </div>
                </form>
              </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-6 col-sm-offset-3 push-lg-3">
                <a href="{{route('products.edit',$product->product_id)}}" class="form-action">Edit</a>
                @if ($product->trashed == 0)
                    <a href="{{route($product->table.'.trash',$product->product_id)}}" class="form-action btn btn-sm btn-warning" aria-label="trash"></a>
                @elseif ($product->trashed == 1)
                    <a href="{{route($product->table.'.restore',$product->product_id)}}" class="form-action btn btn-sm btn-warning" aria-label="restore"></a>
                    <a href="{{route($product->table.'.destroy',$product->product_id)}}" class="form-action btn btn-sm btn-danger" aria-label="destroy"></a>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-lg-6 col-sm-offset-3 push-lg-3">
                <form method="post" action="{{route('cart.add')}}">
                    {{ csrf_field() }}
                    <input type="hidden" name="product_id" value="{{$product->product_id}}">
                    <select name="quantity">
                        @for($i = 0; $i < $product->quantity+1; $i++)
                            @if($i == $product->getQuantity())
                                <option value="{{ $i }}" selected="selected">{{ $i }}</option>
                            @else
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endif
                        @endfor
                    </select>
                    <button type="submit">Add to Cart</button>
                </form>

                <h1>{{ $product->name }}</h1>
                <td>

                <table class="table table-sm table-striped">
                    <tbody>
                    <tr>
                        <th class="align-middle">Name</th>
                        <td class="align-middle">{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Price (Ex. Tax)</th>
                        <td class="align-middle">{{ $product->price }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Discount</th>
                        <td class="align-middle">€ {{ $product->discount_value }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Discount Price</th>
                        <td class="align-middle">€ {{ $product->discount_price }}</td>
                    </tr>
                    <tr>
                        @if($product->lowStock())
                            <th class="align-middle alert-warning">Low Stock!</th>
                            <td class="align-middle alert-warning">{{ $product->quantity }}</td>
                        @elseif($product->outOfStock())
                            <th class="align-middle alert-danger">Out of stock!</th>
                            <td class="align-middle alert-danger">{{ $product->quantity }}</td>
                        @else
                            <th class="align-middle">In Stock</th>
                            <td class="align-middle">{{ $product->quantity }}</td>
                        @endif

                    </tr>
                    <tr>
                        <th class="align-middle">Category</th>
                        <td class="align-middle">{{ $product->category->title }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Tax %{{$product->tax_percentage}} </th>
                        <td class="align-middle">€ {{ $product->tax_value }}</td>
                    </tr>
                    <tr>
                        <th class="align-middle">Total Price (Inc. Tax)</th>
                        <td class="align-middle">€ {{ $product->total() }}</td>
                    </tr>
                    </tbody>
                </table>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#description">Description</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#specifications">Specifications</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#images">Images</a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane container active" id="description">{!! $product->description !!}</div>
                    <div class="tab-pane container fade" id="specifications">
                        {!! $product->specifications !!}
                    </div>
                    <div class="tab-pane container fade" id="images">
                        <select id="product-folder-selector" multiple="multiple" class="image-picker" hidden>
                        @foreach($product->folder->files as $upload)
                                    <div class="col">
                                        <option id="{{$upload->upload_id}}" data-img-src="{{ asset('/storage/'.$upload->path('thumbnail')) }}"
                                                value="{{ asset('/storage/'.$upload->path()) }}">{{$upload->name}}
                                        </option>
                                    </div>
                        @endforeach
                        </select>
                        <div class="row">
                            <div class="col-md-6">
                                <button id="remove-image-from-product" name="remove-image-from-product">Delete Selection</button>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="{{ asset('/vendor/jornschalkwijk/LaravelCMS/assets/js/image-picker/image-picker.js') }}"></script>
    <script>
        $(window).on('load',function(){
            $('#product-folder-selector').imagepicker();
        });
    </script>
    @endpush
    @push('styles')
    <link rel="stylesheet" href="{{ asset('/vendor/jornschalkwijk/LaravelCMS/assets/js/image-picker/image-picker.css') }}"/>
    @endpush

    @push('scripts')
    <script src="{{asset("/vendor/jornschalkwijk/LaravelCMS/assets/js/dropzone/min/dropzone.min.js")}}"></script>
    <script src="{{asset("/vendor/jornschalkwijk/LaravelCMS/assets/js/dropzoneOptions.js")}}"></script>
    @endpush

    @push('styles')
    <link rel="stylesheet" type="text/css" href="{{asset("/vendor/jornschalkwijk/LaravelCMS/assets/js/dropzone/min/dropzone.min.css")}}"/>
    @endpush
@stop