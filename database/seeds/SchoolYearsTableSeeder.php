<?php

use Illuminate\Database\Seeder;
use App\SchoolYear;

class SchoolYearsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SchoolYear::insert([
            ['name' => '2017-2018'],
            ['name' => '2018-2019'],
            ['name' => '2019-2020'],
        ]);
    }
}
