<?php

use App\Models\Channel;
use App\Support\Str;
use Faker\Generator as Faker;

$factory->define(Channel::class, function (Faker $faker) {

    return [
        'name' => Str::slug($faker->words(2, true)),
        'description' => $faker->sentence,
    ];

});
