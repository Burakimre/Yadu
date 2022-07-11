<?php

use Faker\Generator as Faker;

$factory->define(App\EventPicture::class, function (Faker $faker) {
    return [
        'tag_id' => 1,
        'picture' => file_get_contents($faker->imageUrl(960, 640, 'cats'))
    ];
});
