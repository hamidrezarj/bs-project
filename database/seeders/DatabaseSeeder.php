<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'حمیدرضا',
            'last_name' => 'رنجبرپور',
            'email' => 'h@gmail.com',
            'national_code' => '1234567890',
            'phone_number' => '09380220456',
            'user_type' => 'student',
            'password' => Hash::make('123456789'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'فاطمه',
            'last_name' => 'مولایی',
            'email' => 'fmol@sbu.ac.ir',
            'national_code' => '4530952775',
            'phone_number' => '093504229633',
            'user_type' => 'technical_support',
            'password' => Hash::make('123456789'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'فرشته',
            'last_name' => 'نمینی',
            'email' => 'fnamin@sbu.ac.ir',
            'national_code' => '4560953624',
            'phone_number' => '09306547821',
            'user_type' => 'technical_support',
            'password' => Hash::make('123456789'),
        ]);

        DB::table('users')->insert([
            'first_name' => 'سودا',
            'last_name' => 'رضایی',
            'email' => 'sevda@sbu.ac.ir',
            'national_code' => '7520423991',
            'phone_number' => '09214129632',
            'user_type' => 'technical_support',
            'password' => Hash::make('123456789'),
        ]);
    }
}
