<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
			$table->integer('product_id', true);
			$table->string('name', 60);
			$table->integer('category_id');
			$table->float('price', 10, 0);
			$table->string('description', 5000);
			$table->float('discount_price', 10, 0);
			$table->float('savings', 10, 0);
			$table->boolean('tax_percentage');
			$table->float('tax', 10, 0);
			$table->float('total', 10, 0);
			$table->string('img_path', 250);
			$table->integer('folder_id');
			$table->boolean('approved');
			$table->boolean('trashed');
			$table->date('date');
			$table->integer('quantity');
			$table->integer('user_id');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
