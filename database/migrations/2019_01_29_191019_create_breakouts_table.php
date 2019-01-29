<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBreakoutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breakouts', function (Blueprint $table) {
          $table->increments('id');
          $table->integer('event_id');
          $table->integer('presenter_id');
          $table->string('title');
          $table->string('location');
          $table->string('description');
//          $table->string('');

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
        Schema::dropIfExists('breakouts');
    }
}
