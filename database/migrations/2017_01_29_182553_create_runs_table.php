<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('runs', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('submit_id')->unsigned()->nullable();
            $table->foreign('submit_id')->references('id')->on('submits')->onDelete('cascade');

            $table->integer('test_case_id')->unsigned()->nullable();
            $table->foreign('test_case_id')->references('id')->on('test_cases')->onDelete('cascade');

            $table->double('RMSE');
            $table->integer('round_id')->unsigned()->nullable();
            $table->foreign('round_id')->references('id')->on('rounds')->onDelete('cascade');
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
        Schema::dropIfExists('runs');
    }
}
