<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallRecordingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_recordings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('call_id')->nullable()->unsigned();
            $table->foreign('call_id')->references('id')->on('calls');
            $table->integer('duration');
            $table->string('location');
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
        Schema::dropIfExists('call_recordings');
    }
}
