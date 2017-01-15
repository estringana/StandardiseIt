<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Standard::class, function () {
    return [
        'title' => 'Space after the negation symbol',
        'proposition' => 'Add an space after the negation symbol',
        'created_at' => Carbon\Carbon::now(),
    ];
});

$factory->state(App\Standard::class, 'proposed', function () {
    return [
        'proposed_at' => Carbon\Carbon::parse('-1 week'),
    ];
});

$factory->state(App\Standard::class, 'unproposed', function () {
    return [
        'proposed_at' => null,
    ];
});
