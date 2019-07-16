<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Teacher;
use Faker\Generator as Faker;

$factory->define(Teacher::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'birthday' => $faker->date(),
        'password' => Hash::make('123456'), // 123456
        'subject' => array_random(['Toán', 'Vật lý', 'Hoá học'])
    ];
});
