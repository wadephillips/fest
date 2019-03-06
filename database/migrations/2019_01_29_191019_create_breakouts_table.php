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
          $table->integer('event_id')->unsigned()->index();
          $table->string('title');
          $table->string('slug');
          $table->date('date');
          $table->time('start');
          $table->time('end')->nullable();
          $table->string('location')->nullable();
          $table->string('description', 5000);

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
