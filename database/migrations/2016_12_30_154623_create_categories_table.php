<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('category_id',10);
            $table->string('title',130);
            $table->string('description',160);
            $table->text('content');
            $table->mediumText('keywords');
            $table->string('type',15);
            $table->tinyInteger('approved');
            $table->tinyInteger('trashed');
            $table->string('path',150);
            $table->integer('parent_id');
            $table->integer('user_id');
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
        Schema::dropIfExists('categories');
    }
}
