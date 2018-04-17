<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudeDetailFieldTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitude_detail_field', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitude_detail_id');
            $table->unsignedInteger('format_field');
            $table->string('value_field');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('solicitude_detail_id')
                ->references('id')
                ->on('solicitude_details')
                ->onDelete('cascade');
            $table->foreign('format_field')
                ->references('id')
                ->on('solicitudes_format')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('solicitude_detail_field');
    }
}
