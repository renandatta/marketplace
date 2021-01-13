<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Store;
use Faker\Generator as Faker;

$factory->define(Store::class, function (Faker $faker) {
    $locations = json_decode(raja_ongkir_location());
    $province = $locations[rand(0, count($locations)-1)];
    if (count($province->cities) == 0) $province = $locations[11];
    $city = $province->cities[rand(0, count($province->cities)-1)];
//    try {
//
//    } catch (Exception  $e) {
//        dd($province);
//    }

    return [
        'store_level_id' => rand(1, 3),
        'name' => $faker->name,
        'address' => $faker->address,
        'city' => $city->city_name,
        'district' => $faker->sentence(1),
        'phone' => $faker->phoneNumber,
        'email' => $faker->email,
        'logo' => 'https://picsum.photos/id/'. mt_rand(000, 200) .'/400',
        'banner' => 'https://picsum.photos/id/'. mt_rand(000, 200) .'/1000/400',
        'province' => $province->province,
        'city_id' => $city->city_id,
        'province_id' => $province->province_id
    ];
});
