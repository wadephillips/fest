<?php

use Faker\Generator as Faker;

$factory->define(App\License::class, function (Faker $faker) {
    return [
        'attendee_id' => $faker->numberBetween(0, 10),
        'country' => $faker->countryCode,
        'state' => $faker->stateAbbr,
        'number' => $faker->postcode,
    ];
});
