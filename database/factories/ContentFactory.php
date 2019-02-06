<?php

use App\Content;
use Faker\Generator as Faker;

$factory->define(Content::class, function (Faker $faker) {
    return [
        'title' =>  $faker->sentence(5),
        'summary' =>  $faker->sentence(30),
        'description' =>  $faker->realText(rand(80, 600)),
        'media_id' =>  rand(1,20),
        'contentcat_id' =>  rand(1,3)
    ];
});
