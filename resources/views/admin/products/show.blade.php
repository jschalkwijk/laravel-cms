@extends('admin.layout')
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

                @push('scripts')
                <script src="{{asset("js/dropzone/min/dropzone.min.js")}}"></script>
                <script src="{{asset("js/dropzoneOptions.js")}}"></script>
                @endpush

                @push('styles')
                <link rel="stylesheet" type="text/css" href="{{asset("js/dropzone/min/dropzone.min.css")}}"/>
                @endpush
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-lg-6 col-sm-offset-3 push-lg-3">
                <form method="post" action="{{--{{route('products.action',$product->product_id)}}--}}">
                    <input type="hidden" name="id" value="<?= $product->product_id; ?>"/>
                    <input type="hidden" name="name" value="<?= $product->name ?>"/>
                    <?php
                    if ($product->trashed == 1) { // show restore button in deleted items ?>
                    <button type="submit" name="restore">Restore</button>
                    <button type="submit" name="delete"><img class="glyph-small" src="<?= 'delete-post.png'?>"/></button>
                    <?php   }
                    if ($product->trashed == 0) { ?>
                    <button class="td-btn" type="submit" name="remove"><img class="glyph-small" src="<?= 'trash-post.png'?>"/></button>
                    <button><a href="{{route('products.edit',$product->product_id)}}">Edit</a></button>
                    <?php } ?>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-lg-6 col-sm-offset-3 push-lg-3">
                <form class="backend-form" method="post" action="<?="cart/add/".$product->product_id;?>">
                    <select name="quantity">
                        <?php
                        for($i = 0; $i < ($product->quantity + 1); $i++){ ?>
                        <option value="<?= $i; ?>"><?= $i; ?></option>
                        <?php } ?>
                    </select>
                    <button type="submit">Order</button>
                </form>
                <h1><?= $product->name; ?></h1>
                <td><?php if($product->lowStock()) { echo "Low stock!"; } else if($product->outOfStock()) { echo "Out of stock!"; } else { echo "";}?></td>

                <table class="table table-sm table-striped">
                    <tbody>
                    <tr>
                        <th class="align-middle">Name</th>
                        <td class="align-middle"><?= $product->name; ?></td>
                    </tr>
                    <tr>
                        <th class="align-middle">Price (Ex. Tax)</th>
                        <td class="align-middle"><?= $product->price; ?></td>
                    </tr>
                    <tr>
                        <th class="align-middle">Discount</th>
                        <td class="align-middle">€ <?= $product->discount_value; ?></td>
                    </tr>
                    <tr>
                        <th class="align-middle">Discount Price</th>
                        <td class="align-middle">€ <?= $product->discount_price; ?></td>
                    </tr>
                    <tr>
                        <th class="align-middle">In Stock</th>
                        <td class="align-middle"><?= $product->quantity; ?></td>
                    </tr>
                    <tr>
                        <th class="align-middle">Category</th>
                        <td class="align-middle"><?= $product->category->title; ?></td>
                    </tr>
                    <tr>
                        <th class="align-middle">Tax %{{$product->tax_percentage}} </th>
                        <td class="align-middle">€ <?= $product->tax_value; ?></td>
                    </tr>
                    <tr>
                        <th class="align-middle">Total Price (Inc. Tax)</th>
                        <td class="align-middle">€ <?= $product->total(); ?></td>
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
                    <div class="tab-pane container active" id="description"><?= $product->description; ?></div>
                    <div class="tab-pane container fade" id="specifications"><p>Some content in menu 1.</p></div>
                    <div class="tab-pane container fade" id="images"></div>
                </div>
            </div>
        </div>
    </div>



@stop