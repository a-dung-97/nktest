<?php

use Illuminate\Database\Seeder;
use App\Classroom;
use Illuminate\Support\Facades\DB;

class ClassroomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Classroom::insert([
            ['name' => 'A1-K41', 'start_year' => '1'],
            ['name' => 'A1-K42', 'start_year' => '2'],
            ['name' => 'A1-K43', 'start_year' => '3'],
        ]);
        DB::table('classroom_teacher')->insert([
            ['classroom_id' => '1', 'teacher_id' => '1', 'subject_id' => '1', 'school_year_id' => '3'],
            ['classroom_id' => '1', 'teacher_id' => '2', 'subject_id' => '2', 'school_year_id' => '3'],
            ['classroom_id' => '1', 'teacher_id' => '3', 'subject_id' => '3', 'school_year_id' => '3'],
            // ['classroom_id' => '2', 'teacher_id' => '2', 'subject_id' => '2', 'school_year_id' => '3'],
            // ['classroom_id' => '2', 'teacher_id' => '5', 'subject_id' => '5', 'school_year_id' => '3'],
            // ['classroom_id' => '2', 'teacher_id' => '8', 'subject_id' => '8', 'school_year_id' => '3'],
            // ['classroom_id' => '3', 'teacher_id' => '1', 'subject_id' => '1', 'school_year_id' => '3'],
            // ['classroom_id' => '3', 'teacher_id' => '4', 'subject_id' => '4', 'school_year_id' => '3'],
            // ['classroom_id' => '3', 'teacher_id' => '7', 'subject_id' => '7', 'school_year_id' => '3']
        ]);
    }
}
