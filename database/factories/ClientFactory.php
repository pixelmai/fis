<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Clients;
use Faker\Generator as Faker;
use Illuminate\Support\Str;


$factory->define(Clients::class, function (Faker $faker) {
    return [
    	'fname' => $faker->firstName,
        'lname' => $faker->lastName,
        'gender' => 'm',
        'registration_id' => 1,
        'sector_id' => 1,
        'updatedby_id' => 1,
        'email' => $faker->unique()->safeEmail,
    ];
});

