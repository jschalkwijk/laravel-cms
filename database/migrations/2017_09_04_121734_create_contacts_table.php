<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('contacts_id',10);
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->string('email_1');
            $table->string('email_2');
            $table->string('password');
            $table->string('dob');
            $table->string('street');
            $table->string('street_num');
            $table->string('street_num_add');
            $table->string('zip');
            $table->string('notes');
            $table->tinyInteger('approved');
            $table->tinyInteger('trashed');
            $table->integer('user_id');
            $table->integer('created_by');
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
        //
    }
}
