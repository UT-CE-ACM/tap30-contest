<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestCasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rounds', function (Blueprint $table){
            $table->increments('id');
            $table->integer('number')->unsigned();
            $table->boolean('is_finished')->default(false);
            $table->timestamps();
        });
        Schema::create('test_cases', function (Blueprint $table) {
            $table->increments('id');
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
        Schema::dropIfExists('test_cases');
        Schema::dropIfExists('rounds');
    }
}
