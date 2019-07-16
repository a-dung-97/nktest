<?php

use Illuminate\Database\Seeder;
use App\Subject;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subject::insert([
            // ['name' => 'Toán 10'],
            // ['name' => 'Toán 11'],
            ['name' => 'Toán 12'],
            // ['name' => 'Vật lý 10'],
            // ['name' => 'Vật lý 11'],
            ['name' => 'Vật lý 12'],
            // ['name' => 'Hoá học 10'],
            // ['name' => 'Hoá học 11'],
            ['name' => 'Hoá học 12']
        ]);
    }
}
