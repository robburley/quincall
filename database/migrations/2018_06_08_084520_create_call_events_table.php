<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCallEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('call_events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('call_id')->nullable()->unsigned();
            $table->foreign('call_id')->references('id')->on('calls');
            $table->string('event');
            $table->timestamp('timestamp');
            $table->integer('sequence_step');
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
        Schema::dropIfExists('call_events');
    }
}
