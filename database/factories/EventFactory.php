<?php

use Faker\Generator as Faker;

$factory->define(App\Event::class, function (Faker $faker) {
    return [
        'status' => 'ongoing',
        'tag_id' => 1,
        'location_id' => $faker->numberBetween(1,10),
        'owner_id' => '1',
        'eventName' => 'museum',
        'startDate' => Carbon::parse(date('Y-m-d H:i'))->addDays(7),
        'endDate' => $faker->dateTimeBetween('+2 week', '+1 month'),
        'numberOfPeople' => 1,
        'description' => $faker->text,
        'event_picture_id' => 1
    ];
});
