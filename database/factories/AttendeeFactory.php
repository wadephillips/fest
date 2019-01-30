<?php

use Faker\Generator as Faker;

$factory->define(App\Attendee::class, function (Faker $faker) {
  $json = json_encode([
      [ 'option' => $faker->word, 'price' => $faker->numberBetween(0, 20000), 'quantity' => $faker->numberBetween(0,10),],
      [ 'option' => $faker->word, 'price' => $faker->numberBetween(0, 20000), 'quantity' => $faker->numberBetween(0,10),],
      [ 'option' => $faker->word, 'price' => $faker->numberBetween(0, 20000), 'quantity' => $faker->numberBetween(0,10),],
  ]);

  return [
      'event_id' => $faker->numberBetween(1,10),
      'payment_id' => $faker->numberBetween(1,50),
      'name' => $faker->name,
      'email' => $faker->email,
      'phone' => $faker->phoneNumber,
      'address' => $faker->streetAddress,
      'address_2' => $faker->optional()->secondaryAddress,
      'suite' => $faker->optional()->secondaryAddress,
      'city' => $faker->city,
      'state' => $faker->stateAbbr,
      'postal' => $faker->postcode,
      'country' => $faker->countryCode,
      'emergency_contact_name' => $faker->name,
      'emergency_contact_phone' => $faker->phoneNumber,
      'emergency_contact_relation' => $faker->word,
      'modifiers' => $json,
      'total' => $faker->numberBetween(0,250000)
  ];
});
