<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Courier;
use Faker\Generator as Faker;

$factory->define(Courier::class, function (Faker $faker) {
    return [
        'name' => $faker->company
    ];
});
