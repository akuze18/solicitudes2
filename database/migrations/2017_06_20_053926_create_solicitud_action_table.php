<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitudes_action', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',15);
            $table->string('name',100);
            $table->integer('orderBy');
            $table->unsignedInteger('type');
            $table->foreign('type')
                ->references('id')
                ->on('solicitudes_type')
                ->onDelete('cascade');
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
        Schema::drop('solicitudes_action');
    }
}
