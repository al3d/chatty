<?php

use App\Models\User;
use App\Support\Str;
use Faker\Generator as Faker;

$factory->define(User::class, function (Faker $faker) {

    $updatedAt = $faker->dateTimeBetween('-3 days', 'now');

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token' => Str::random(10),
        'last_login_at' => $updatedAt,
        'created_at' => $faker->dateTimeBetween('-10 days', $updatedAt),
        'updated_at' => $updatedAt,
    ];
});
