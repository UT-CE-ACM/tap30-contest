<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('first_record_id')->unsigned()->nullable();
            $table->foreign('first_record_id')->references('id')->on('records')->onDelete('set null');
            $table->integer('second_record_id')->unsigned()->nullable();
            $table->foreign('second_record_id')->references('id')->on('records')->onDelete('set null');

            $table->integer('round_id')->unsigned()->nullable();
            $table->foreign('round_id')->references('id')->on('rounds')->onDelete('cascade');

            $table->integer('winner_id')->unsigned()->nullable()->default(null);
            $table->foreign('winner_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('records');
    }
}
