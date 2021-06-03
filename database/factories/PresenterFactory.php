<?php

use Faker\Generator as Faker;

$factory->define(App\Presenter::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'credentials' => $faker->optional(.8)->words(3, true),
        'bio' => $faker->paragraph(3, true),
    ];
});
