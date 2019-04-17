<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoicemailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voicemails', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->nullable()->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('call_sid');
            $table->string('recording_sid');
            $table->string('from');
            $table->string('to');
            $table->integer('duration')->nullable();
            $table->string('external_url')->nullable();
            $table->string('location')->nullable();
            $table->timestamp('downloaded_at')->nullable();
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
        Schema::dropIfExists('voicemails');
    }
}
