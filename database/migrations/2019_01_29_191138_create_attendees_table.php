<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendees', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_id')->unsigned()->index();
            $table->integer('payment_id')->unsigned()->index();
            $table->string('name');
            $table->string('email', 100);
            $table->string('phone', 16);
            $table->string('address');
            $table->string('address_2')->nullable();
            $table->string('suite');
            $table->string('city');
            $table->string('state', 3);
            $table->string('postal', 10);
            $table->string('country', 2);

            $table->string('emergency_contact_name');
            $table->string('emergency_contact_phone');
            $table->string('emergency_contact_relation');

            $table->json('modifiers')->nullable();
            $table->integer('total')->default(0);


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
        Schema::dropIfExists('attendees');
    }
}
