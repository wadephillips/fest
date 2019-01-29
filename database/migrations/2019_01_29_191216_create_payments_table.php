<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('payments', function (Blueprint $table) {
      $table->increments('id');
      $table->string('event_id');
      $table->string('payer_id'); //foreign key to attendee
      $table->string('amount');
      $table->string('status');
      $table->string('token');
      //billing address
      $table->string('address');
      $table->string('address_2')->nullable();
      $table->string('suite');
      $table->string('city');
      $table->string('state', 3);
      $table->string('postal', 10);
      $table->string('country', 2);
      // processor provided info
      $table->string('processor_customer_id');
      $table->string('processor_customer_id');
      $table->string('processor_invoice_id');
      $table->string('processor_subscription_id');

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
    Schema::dropIfExists('payments');
  }
}
