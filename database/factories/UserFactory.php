<?php

use App\Role;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'username' => $faker->userName,
        'email' => $faker->unique()->safeEmail,
        'family' =>  $faker->lastName,
        'mobile' =>  $faker->phoneNumber,
        'role_id' => Role::where('slug','user')->first()->id,
        'password' =>  $faker->password,
        'media_id' =>  rand(1,20),
        'is_active' =>  $faker->boolean,
    ];
});
