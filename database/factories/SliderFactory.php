<?php

use App\Slider;
use Faker\Generator as Faker;

$factory->define(Slider::class, function (Faker $faker) {
    $slider_type = [
        0 => 'Products',
        1 => 'Loot',
    ];
    return [
        'title' =>  $faker->sentence(5),
        'link' =>  $faker->url,
        'image_media_id' =>  rand(1, 30),
        'logo_media_id' =>  rand(1, 30),
        'type' =>  $slider_type[rand(0,1)]
    ];
});
