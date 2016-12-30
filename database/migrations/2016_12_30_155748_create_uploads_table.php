<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->increments('upload_id');
            $table->string('name');
            $table->string('type');
            $table->string('file_name');
            $table->string('thumb_name');
            $table->string('file_path',2000);
            $table->string('thumb_path',2000);
            $table->integer('folder_id',10);
            $table->integer('user_id',10);
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
        Schema::dropIfExists('uploads');
    }
}
