<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Question;
use Faker\Generator as Faker;
use App\Teacher;
use Illuminate\Support\Facades\DB;

$factory->define(Question::class, function (Faker $faker) {
    $teacher = Teacher::all()->random();
    $subject = DB::table('teachers')->where('id', '=', $teacher->id)->first()->subject;
    $topic = DB::table('subjects')
        ->join('topics', 'subjects.id', '=', 'topics.subject_id')
        ->select('topics.*')
        ->where('subjects.name', 'like', $subject . '%')
        ->get();
    return [
        'content' => $faker->text(),
        'answers' => [
            'A' => $faker->sentence(),
            'B' => $faker->sentence(),
            'C' => $faker->sentence(),
            'D' => $faker->sentence()
        ],
        'true_answer' => array_random(['A', 'B', 'C', 'D']),
        'level' => rand(1, 3),
        'teacher_id' => $teacher->id,
        'topic_id' => $topic->random()->id
    ];
});
