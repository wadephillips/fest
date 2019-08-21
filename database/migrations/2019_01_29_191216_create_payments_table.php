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
//      $table->increments('id');
      $table->uuid('id')->primary();
      $table->integer('event_id')->unsigned()->index();
      $table->integer('payer_id')->nullable()->unsigned()->index(); //foreign key to attendee
      $table->integer('amount');
      $table->string('status');
      $table->string('token');
      //billing address
      $table->string('address');
      $table->string('address_2')->nullable();
      $table->string('suite')->nullable();
      $table->string('city');
      $table->string('state', 3);
      $table->string('postal', 10);
      $table->string('country', 2);
      // processor provided info
      $table->string('processor');
      $table->string('processor_transaction_id');
      $table->string('processor_customer_id')->nullable();
      $table->string('processor_invoice_id')->nullable();
      $table->string('processor_subscription_id')->nullable();

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
