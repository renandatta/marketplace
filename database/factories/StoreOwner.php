<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\StoreOwner;
use Faker\Generator as Faker;

$factory->define(StoreOwner::class, function (Faker $faker) {
    return [
        'store_id' => rand(1, 10),
        'user_id' => rand(1, 50)
    ];
});
