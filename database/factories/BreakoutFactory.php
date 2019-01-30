<?php

use Faker\Generator as Faker;

$factory->define(App\Breakout::class, function (Faker $faker) {
  $title = $faker->sentence;
  return [
      'event_id' => $faker->numberBetween(0,50),
      'title' => $title,
      'slug' => str_slug($title, '-'),
      'location' => $faker->words(rand(2,5), true ),
      'description' => $faker->paragraphs(rand(1,3),true),
  ];
});
