<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormatListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('format_list', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('format_id');
            $table->string('value');
            $table->string('display');
            $table->timestamps();
            $table->foreign('format_id')
                ->references('id')
                ->on('solicitudes_format')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('format_list');
    }
}
