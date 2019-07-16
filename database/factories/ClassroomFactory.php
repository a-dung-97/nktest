<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Classroom;
use Faker\Generator as Faker;
use App\SchoolYear;

$factory->define(Classroom::class, function (Faker $faker) {
    return [
        'name' => 'A' . rand(1, 3),
        'start_year' => function () {
            return SchoolYear::all()->random();
        }
    ];
});
