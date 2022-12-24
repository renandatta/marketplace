<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Slider;
use Faker\Generator as Faker;

$factory->define(Slider::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(2),
        'image' => 'https://picsum.photos/id/'. mt_rand(000, 200) .'/1000/400'
    ];
});
