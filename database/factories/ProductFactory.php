<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'title' =>  $faker->sentence(5),
        'summary' =>  $faker->sentence(30),
        'description' =>  $faker->realText(rand(80, 600)),
        'media_id' =>  rand(1,20),
        'code' =>  $faker->shuffleString('p-albumseries'),
        'inventory' =>  rand(0,100),
        'price' =>  rand(10000,20000),
        'productcat_id' =>  rand(1,3),
    ];
});
