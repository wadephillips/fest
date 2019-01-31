<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
  $name = $faker->sentence;
  $date = $faker->dateTimeInInterval('now', '+365 days');
  return [
  'name' => $name,
  'slug' => str_slug($name, '-'),
  'start' => $date,
  'end' => $date->add(new DateInterval('P3D')),
  'description' => $faker->paragraph(3, true),
  'active' => 1,
  'address' => $faker->streetAddress,
  'address_2' => $faker->optional()->secondaryAddress,
  'suite' => $faker->optional()->secondaryAddress,
  'city' => $faker->city,
  'state' => $faker->stateAbbr,
  'postal' => $faker->postcode,
  'country' => $faker->countryCode,
  ];
});
