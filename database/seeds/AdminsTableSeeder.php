<?php

use Illuminate\Database\Seeder;
use App\Admin;
use Illuminate\Support\Facades\Hash;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Nguyễn Anh Dũng',
            'email' => 'dungnknd97@gmail.com',
            'password' => Hash::make('123456'),
        ]);
    }
}
