<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Topic;
use Faker\Generator as Faker;
use App\Subject;

$factory->define(Topic::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(),
        'subject_id' => function () {
            return Subject::all()->random();
        }
    ];
});
