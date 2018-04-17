<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('header',50);
            $table->string('contain',70);
            $table->string('route',80);
            $table->string('icon_name',80);
            $table->string('parameter1',80);
            $table->string('parameter2',80);
            $table->string('permission');
            $table->unsignedInteger('orderBy')->default(0);
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
        Schema::drop('menus');
    }
}
