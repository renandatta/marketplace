<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\CourierService;
use Faker\Generator as Faker;

$factory->define(CourierService::class, function (Faker $faker) {
    return [
        'name' => $faker->firstName,
        'price' => intval(mt_rand(0000, 9999))
    ];
});
