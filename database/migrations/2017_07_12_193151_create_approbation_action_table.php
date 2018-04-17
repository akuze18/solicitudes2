<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApprobationActionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('approbation_actions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description',30);
            $table->unsignedInteger('status');
            $table->timestamps();
            $table->foreign('status')
                ->references('id')
                ->on('estados')
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
        Schema::drop('approbation_actions');
    }
}
