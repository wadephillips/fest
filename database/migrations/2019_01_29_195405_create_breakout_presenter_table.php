<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBreakoutPresenterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breakout_presenter', function (Blueprint $table) {
          $table->integer('breakout_id')->unsigned()->index();
          $table->foreign('breakout_id')->references('id')->on('breakouts')->onDelete('cascade');

          $table->integer('presenter_id')->unsigned()->index();
          $table->foreign('presenter_id')->references('id')->on('presenters')->onDelete('cascade');
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
        Schema::dropIfExists('breakout_presenter');
    }
}
