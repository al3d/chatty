<?php

use App\Models\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {

    return [
        'message' => $faker->realText(rand(40, 300)),
    ];
});
