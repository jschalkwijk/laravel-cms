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
			$table->float('price', 10, 0);
			$table->string('description', 5000);
			$table->string('specifications', 5000)->nullable();
			$table->integer('quantity');
			$table->boolean('tax_percentage');
			$table->float('tax_value', 10, 0);
			$table->boolean('discount_percentage')->default(0);
			$table->float('discount_value', 10, 0)->default(0);
			$table->float('discount_price', 10, 0)->nullable();
			$table->integer('folder_id')->nullable();
			$table->integer('category_id');
			$table->integer('user_id');
			$table->boolean('approved')->default(0);
			$table->boolean('trashed')->default(0);
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
		Schema::drop('products');
	}

}
