<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id',10);
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->binary('email')->unique();
            $table->string('password');
            $table->binary('dob');
            $table->binary('function');
            $table->binary('rights');
            $table->string('img_path',1000);
            $table->tinyInteger('approved');
            $table->tinyInteger('trashed');
            $table->integer('album_id',10);
            $table->integer('created_by',10);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
