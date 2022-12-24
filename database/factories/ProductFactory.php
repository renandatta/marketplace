<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'store_id' => rand(1, 10),
        'product_category_id' => rand(1, 40),
        'name' => $faker->sentence(rand(4, 6)),
        'price' => rand(10000, 999999),
        'weight' => rand(1, 10),
        'condition' => 'New',
        'stock' => rand(1, 100),
        'stock_min' => 2,
        'description' => $faker->paragraphs(rand(3, 5), true)
    ];
});
