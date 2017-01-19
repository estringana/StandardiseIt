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
use App\Standard;
use Carbon\Carbon;
use App\User;
use Faker\Generator as FakerGenerator;

$factory->define(User::class, function (FakerGenerator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(Standard::class, function () {
    return [
        'title' => 'Space after the negation symbol',
        'proposition' => 'Add an space after the negation symbol',
        'created_at' => Carbon::now(),
    ];
});

foreach (Standard::STATUSES as $status) {
    $factory->state(Standard::class, $status, function () use ($status) {
        return [
            'status' => $status
        ];
    });
}
