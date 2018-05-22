<?php

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
        'email' => $faker->unique()->safeEmail,
        'username' => $faker->unique()->username,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});
$factory->define(App\Article::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'active' => 1,
        'keywords' => array('done','hoooray'),
        'body' => $faker->paragraph,
        'user_id' => factory('App\User')->create()->id,
        'description' => $faker->sentence,
        'meta_description' => $faker->sentence
    ];
});