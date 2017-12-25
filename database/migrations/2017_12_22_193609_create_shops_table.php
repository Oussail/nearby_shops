<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('t_shop', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shop_name');
            $table->string('shop_description');
            $table->text('shop_photo');
            $table->dateTime('creation_date');
            $table->decimal('lat', 10, 8);
            $table->decimal('lng', 11, 8);
        });
       Schema::create('t_liked', function (Blueprint $table) {
            $table->dateTime('liked');
            $table->smallInteger('user_id')->unsigned();
            $table->smallInteger('shop_id')->unsigned();
            $table->primary(array('user_id', 'shop_id'));
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('t_shop')->onDelete('cascade');
        });
       Schema::create('t_disliked', function (Blueprint $table) {
            $table->dateTime('unliked');
            $table->smallInteger('user_id')->unsigned();
            $table->smallInteger('shop_id')->unsigned();
            $table->primary(array('user_id', 'shop_id'));
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('shop_id')->references('id')->on('t_shop')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        /*Schema::dropIfExists('t_shop');
        Schema::dropIfExists('t_liked');
        Schema::dropIfExists('t_disliked');*/
    }
}
