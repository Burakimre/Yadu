<?php

use Faker\Generator as Faker;

$factory->define(App\Location::class, function (Faker $faker) {
    return [
        'houseNumber' => $faker->numberBetween(1, 200),
        'postalCode' => $faker->unique()->postcode
    ];
});
