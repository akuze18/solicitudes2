<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprobationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approbations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('solicitude_batch_id');
            $table->unsignedInteger('solicitude_detail_id');
            $table->integer('order');
            $table->unsignedInteger('action_id');
            $table->unsignedInteger('format_id');
            $table->unsignedInteger('approver_id');
            $table->string('observation',150);
            $table->timestamps();
            $table->foreign('solicitude_batch_id')
                ->references('id')
                ->on('solicitudes')
                ->onDelete('cascade');

            $table->foreign('solicitude_detail_id')
                ->references('id')
                ->on('solicitude_details')
                ->onDelete('NO ACTION');

            $table->foreign('action_id')
                ->references('id')
                ->on('approbation_actions')
                ->onDelete('cascade');

            $table->foreign('format_id')
                ->references('id')
                ->on('approbation_formats')
                ->onDelete('cascade');

            $table->foreign('approver_id')
                ->references('id')
                ->on('users')
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
        Schema::drop('approbations');
    }
}
