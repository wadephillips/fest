<?php

use Faker\Generator as Faker;

$factory->define(App\Payment::class, function (Faker $faker) {
  return [
      'event_id' => $faker->numberBetween(1,10),
      'payer_id' => $faker->numberBetween(1,50),
      'amount' => $faker->numberBetween(0,250000),
      'status' => $faker->word,
      'token' => $faker->uuid,
      'address' => $faker->streetAddress,
      'address_2' => $faker->optional()->secondaryAddress,
      'suite' => $faker->optional()->secondaryAddress,
      'city' => $faker->city,
      'state' => $faker->stateAbbr,
      'postal' => $faker->postcode,
      'country' => $faker->countryCode,
      'processor' => $faker->word,
      'processor_transaction_id' => $faker->uuid,
      'processor_customer_id' => $faker->uuid,
      'processor_invoice_id' => $faker->uuid,
      'processor_subscription_id' => $faker->uuid,
  ];
});
