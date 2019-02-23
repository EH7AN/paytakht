<?php

use App\Discount;
use Faker\Generator as Faker;

$factory->define(Discount::class, function (Faker $faker) {
    return [
        'product_id' =>  rand(1, 30),
        'value' =>  rand(10, 100),
        'start_time' =>  $faker->date(),
        'end_time' =>  $faker->date(),
    ];
});
