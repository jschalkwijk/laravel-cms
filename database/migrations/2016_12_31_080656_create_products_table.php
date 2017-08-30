<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id',10);
            $table->text('name' ,60);
            $table->text('description',160);
            $table->float('price',6);
            $table->integer('quantity');
            $table->float('discount_price',6);
            $table->float('savings',6);
            $table->tinyInteger('tax_percentage');
            $table->float('tax',6);
            $table->text('img_path',1000);
            $table->integer('category_id');
            $table->integer('folder_id');
            $table->tinyInteger('approved');
            $table->tinyInteger('trashed');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
