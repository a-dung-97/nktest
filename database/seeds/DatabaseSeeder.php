<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Classroom;
use Illuminate\Support\Facades\DB;
use App\Score;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::create([
        //     'name' => 'Nguyễn Anh Dũng',
        //     'email' => 'dungnknd97@gmail.com',
        //     'password' => Hash::make('123456'),
        //     'gender' => 1,
        //     'birthday' => '1992-06-18',
        //     'role' => 1,
        // ]);
        // $teacher1 = User::create([
        //     'name' => 'Võ Đình Thuần',
        //     'password' => Hash::make('123456'),
        //     'email' => 'thuan.vodinh1@nk.edu.vn',
        //     'gender' => 1,
        //     'birthday' => '1987-04-19',
        //     'role' => 2,
        // ]);
        // $teacher1->teacher()->create([
        //     'subject' => 'Toán',
        // ]);
        // $teacher2 = User::create([

        //     'name' => 'Trần Thị An',
        //     'password' => Hash::make('123456'),
        //     'email' => 'an.tranthi2@nk.edu.vn',
        //     'role' => 2,
        //     'gender' => 1,
        //     'birthday' => '1989-05-09',

        // ]);
        // $teacher2->teacher()->create([
        //     'subject' => 'Vật lý',
        // ]);
        // $teacher3 = User::create([

        //     'name' => 'Nguyễn Hồng Hải',
        //     'password' => Hash::make('123456'),
        //     'email' => 'hai.nguyenhong3@nk.edu.vn',
        //     'role' => 2,
        //     'gender' => 1,
        //     'birthday' => '1993-07-11',

        // ]);
        // $teacher3->teacher()->create([
        //     'subject' => 'Hoá học',
        // ]);
        // $this->call([
        //     SubjectsTableSeeder::class,
        //     SchoolYearsTableSeeder::class,
        //     ClassroomsTableSeeder::class,
        // ]);

        // factory(App\User::class, 150)->create()->each(function ($user) {
        //     $user->student()->create([
        //         'classroom_id' => Classroom::all()->random()->id,
        //     ]);
        // });

        //factory(App\Topic::class, 20)->create();
        // factory(App\Question::class, 1500)->create();
        $students = Score::all()->pluck('id')->all();
        foreach ($students as $student) {
            Score::find($student)->update([
                'result' => rand(0, 20) / 2
            ]);
        }
        // DB::update('')
    }
}
