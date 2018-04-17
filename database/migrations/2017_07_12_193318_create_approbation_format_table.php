<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprobationFormatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approbation_formats', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitude_type_id');
            $table->integer('order');
            $table->string('pattern_approver');
            $table->boolean('wait');
            $table->boolean('required');
            $table->timestamps();
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
        Schema::drop('approbation_formats');
    }
}
