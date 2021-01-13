<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductDiscussion;
use Faker\Generator as Faker;

$factory->define(ProductDiscussion::class, function (Faker $faker) {
    return [
        'content' => $faker->sentence(rand(10, 20))
    ];
});
