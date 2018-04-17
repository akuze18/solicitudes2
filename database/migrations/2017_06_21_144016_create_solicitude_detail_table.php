<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudeDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('solicitude_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitude_id');
            $table->unsignedInteger('action');
            $table->unsignedInteger('type_id');  //proveedor,cliente,articulos,usuarios: inicialmente
            $table->string('comments');
            $table->string('observation');
            $table->unsignedInteger('estado_id');
            $table->unsignedInteger('reference')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('type_id')
                ->references('id')
                ->on('solicitudes_type')
                ->onDelete('no action');
            $table->foreign('solicitude_id')
                ->references('id')
                ->on('solicitudes')
                ->onDelete('cascade');
            $table->foreign('action')
                ->references('id')
                ->on('solicitudes_action')
                ->onDelete('no action');
            $table->foreign('estado_id')
                ->references('id')
                ->on('estados')
                ->onDelete('cascade');
            $table->foreign('reference')
                ->references('id')
                ->on('solicitude_details')
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
        Schema::drop('solicitude_details');
    }
}
