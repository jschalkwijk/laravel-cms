@extends('admin.layout')
@section('content')

    <div class="container">
        <div class="row">
            <div class="col-sm-6 col-lg-6 col-sm-offset-3 push-lg-3">

                <form class="small" enctype="multipart/form-data" method="post" action="">
                    <input type="hidden" name="MAX_FILE_SIZE" value="43500000" />
                    <label for="files[]">Choose File(max size: 3.5 MB): </label><br />
                    <input type="file" name="files[]" multiple/><br />
                    <input type="checkbox" name="public" value="public"/>
                    <label for='public'>Public</label>
                    <input type="checkbox" name="secure" value="secure"/>
                    <label for='secure'>Secure</label>
                    <input type="hidden" name="album_name" value=""/>
                    <input type="hidden" name="category_name" value="<?= $product->category; ?>"/>
                    <input type="hidden" name="album_id" value="<?= $product->folder_id; ?>"/>
                    {{-- select folder--}}

                    <input type="text" name="new_album_name" placeholder="Create New Folder" maxlength="60"/>

                    <button type="submit" name="submit_file">Add File('s)</button>
                </form>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-6 col-lg-6 col-sm-offset-3 push-lg-3">
                <form method="post" action="<?= 'products/info/'.$product->product_id.'/'.$product->name; ?>">
                    <input type="hidden" name="id" value="<?= $product->product_id; ?>"/>
                    <input type="hidden" name="name" value="<?= $product->name ?>"/>
                    <?php
                    if ($product->trashed == 1) { // show restore button in deleted items ?>
                    <button type="submit" name="restore">Restore</button>
                    <button type="submit" name="delete"><img class="glyph-small" src="<?= 'delete-post.png'?>"/></button>
                    <?php   }
                    if ($product->trashed == 0) { ?>
                    <button class="td-btn" type="submit" name="remove"><img class="glyph-small" src="<?= 'trash-post.png'?>"/></button>
                    <button><?= '<a href="'.'/products/edit/'.$product->product_id.'">Edit</a>'?></button>
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
                <img class="left" src="<?= '/admin/'.$product->img_path; ?>"/>
                <table>
                    <tbody>
                    <tr>
                        <td>Product Name</td>
                        <td><?= $product->name; ?></td>
                    </tr>
                    <tr>
                        <td>Price</td>
                        <td><?= $product->price; ?></td>
                    </tr>
                    <tr>
                        <td>In Stock</td>
                        <td><?= $product->quantity; ?></td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td><?= $product->category->title; ?></td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td><?= $product->description; ?></td>
                    </tr>
                    <tr>
                        <td>VAT</td>
                        <td><?= $product->getTax(); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>



@stop