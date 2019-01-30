<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('events', function (Blueprint $table) {
      $table->increments('id');
      //meta
      $table->string('name');
      $table->string('slug');
      $table->dateTime('start');
      $table->dateTime('end');
      $table->string('description', 5000);
      $table->boolean('active')->default(1);
      //location
      $table->string('address');
      $table->string('address_2')->nullable();
      $table->string('suite')->nullable();
      $table->string('city');
      $table->string('state', 3);
      $table->string('postal', 10);
      $table->string('country', 2);

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
    Schema::dropIfExists('events');
  }
}
