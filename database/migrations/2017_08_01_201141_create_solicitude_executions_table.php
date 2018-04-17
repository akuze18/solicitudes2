<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudeExecutionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitude_executions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('action_id');
            $table->integer('imageable_id');
            $table->string('imageable_type');
            $table->timestamps();
            $table->foreign('action_id')
                ->references('id')
                ->on('solicitudes_action')
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
        Schema::drop('solicitude_executions');
    }
}
