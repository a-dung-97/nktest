<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TeachersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teachers')->insert([
            [
                'name' => 'Võ Đình Thuần',
                'birthday' => date('Y-m-d', mt_rand(1, time())),
                'password' => Hash::make('123456'),
                'subject' => 'Toán',
                'email' => 'thuan.vodinh1@nk.edu.vn'
            ],
            // [
            //     'name' => 'Phan Hồng Anh',
            //     'birthday' => date('Y-m-d', mt_rand(1, time())),
            //     'password' => Hash::make('123456'),
            //     'subject' => 'Toán',
            //     'email' => 'phanhonganh@gmail.com'
            // ],
            // [
            //     'name' => 'Nguyễn Thanh Bình',
            //     'birthday' => date('Y-m-d', mt_rand(1, time())),
            //     'password' => Hash::make('123456'),
            //     'subject' => 'Toán',
            //     'email' => 'nguyenthanhbinh@gmail.com'
            // ],
            [
                'name' => 'Trần Thị An',
                'birthday' => date('Y-m-d', mt_rand(1, time())),
                'password' => Hash::make('123456'),
                'subject' => 'Vật lý',
                'email' => 'an.tranthi2@nk.edu.vn'
            ],
            // [
            //     'name' => 'Lê Mạnh Cường',
            //     'birthday' => date('Y-m-d', mt_rand(1, time())),
            //     'password' => Hash::make('123456'),
            //     'subject' => 'Vật lý',
            //     'email' => 'lemanhcuong@gmail.com'
            // ],
            // [
            //     'name' => 'Nguyễn Thùy Linh',
            //     'birthday' => date('Y-m-d', mt_rand(1, time())),
            //     'password' => Hash::make('123456'),
            //     'subject' => 'Vật lý',
            //     'email' => 'nguyenthuylinh@gmail.com'
            // ],
            [
                'name' => 'Nguyễn Hồng Hải',
                'birthday' => date('Y-m-d', mt_rand(1, time())),
                'password' => Hash::make('123456'),
                'subject' => 'Hoá học',
                'email' => 'hai.nguyenhong3@nk.edu.vn'
            ],
            // [
            //     'name' => 'Nguyễn Thị Hồng',
            //     'birthday' => date('Y-m-d', mt_rand(1, time())),
            //     'password' => Hash::make('123456'),
            //     'subject' => 'Hoá học',
            //     'email' => 'nguyenthihong@gmail.com'
            // ],
            // [
            //     'name' => 'Hoàng Thị Yến',
            //     'birthday' => date('Y-m-d', mt_rand(1, time())),
            //     'password' => Hash::make('123456'),
            //     'subject' => 'Hoá học',
            //     'email' => 'hoangthiyen@gmail.com'
            // ],
        ]);
    }
}
