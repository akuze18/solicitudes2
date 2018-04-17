<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudeFormatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes_format', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitude_type_id');
            $table->string('name_field');
            $table->string('type_field');
            $table->string('long_field');
            $table->integer('orderBy');
            $table->boolean('required');
            $table->boolean('title');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('solicitude_type_id')
                ->references('id')
                ->on('solicitudes_type')
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
        Schema::drop('solicitudes_format');
    }
}
