<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->uuid('payment_id')->index();
            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('phone', 16);
            $table->string('address', 100);
            $table->string('address_2', 100)->nullable();
            $table->string('suite', 50)->nullable();
            $table->string('city');
            $table->string('state', 3);
            $table->string('postal', 10);
            $table->string('country', 2);

            $table->string('emergency_contact_name', 100);
            $table->string('emergency_contact_phone', 16);
            $table->string('emergency_contact_relationship', 50);

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
