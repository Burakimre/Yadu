<?php

use Faker\Generator as Faker;

$factory->define(App\EventTag::class, function (Faker $faker) {
    return [
        'tag' => 'random tag',
        'imageDefault' => file_get_contents($faker->imageUrl(960, 640, 'cats')),
        'imageSelected' => file_get_contents($faker->imageUrl(960, 640, 'cats'))
    ];
});
