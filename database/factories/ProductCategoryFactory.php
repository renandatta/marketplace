<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\ProductCategory;
use Faker\Generator as Faker;

$factory->define(ProductCategory::class, function (Faker $faker) {
    static $code = 1;
    return [
        'name' => $faker->sentence(rand(1, 2)),
        'description' => $faker->sentence(rand(4, 5)),
        'code' => strlen($code) == 1 ? '0' . $code++ : $code++,
    ];
});
