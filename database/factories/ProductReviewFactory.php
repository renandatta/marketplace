<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductReview;
use Faker\Generator as Faker;

$factory->define(ProductReview::class, function (Faker $faker) {
    return [
        'user_id' => rand(2, 50),
        'rating' => rand(1, 5),
        'review' => $faker->sentence(3, 7)
    ];
});
