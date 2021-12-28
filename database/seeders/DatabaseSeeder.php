<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $u1 = User::create([
            'first_name' => 'حمیدرضا',
            'last_name' => 'رنجبرپور',
            'email' => 'h@gmail.com',
            'national_code' => '1234567890',
            'phone_number' => '09380220456',
            'user_type' => 'student',
            'password' => '123456789',
        ]);

        $u1->assignRole('user');
        $expireDate = Carbon::now()->addMinutes(5);
        $expireDate2 = Carbon::now()->addDays(2);
        $u1->tickets()->createMany([
            ['course_name' => 'هوش محاسباتی', 'course_id' => 654123987, 'description' => 'some shit', 'expire_date' => $expireDate, 'status' => 'open', 'status_id' => 1],
            ['course_name' => 'معادلات', 'course_id' => 541236987, 'description' => "a discusting dog's poop", 'expire_date' => $expireDate, 'status' => 'open', 'status_id' => 1],
            ['course_name' => 'ریزپردازنده', 'course_id' => 741258963, 'description' => 'درسش حامله کنه', 'expire_date' => $expireDate2, 'status' => 'answered', 'status_id' => 2],
            ['course_name' => 'نظریه زبان ها', 'course_id' => 123654741, 'description' => 'این که خدای کصشره', 'expire_date' => $expireDate2, 'status' => 'completed', 'status_id' => 3],
            ['course_name' => 'هوش محاسباتی', 'course_id' => 654123987, 'description' => 'some shit', 'expire_date' => $expireDate2, 'status' => 'failed', 'status_id' => 4],
        ]);

        $u2 = User::create([
            'first_name' => 'فاطمه',
            'last_name' => 'مولایی',
            'email' => 'fmol@sbu.ac.ir',
            'national_code' => '4530952775',
            'phone_number' => '093504229633',
            'user_type' => 'technical_support',
            'password' => '123456789',
        ]);

        $u2->assignRole('technical_support');

        $u3 = User::create([
            'first_name' => 'فرشته',
            'last_name' => 'نمینی',
            'email' => 'fnamin@sbu.ac.ir',
            'national_code' => '4560953624',
            'phone_number' => '09306547821',
            'user_type' => 'technical_support',
            'password' => '123456789',
        ]);

        $u3->assignRole('technical_support');

        $u4 = User::create([
            'first_name' => 'سودا',
            'last_name' => 'رضایی',
            'email' => 'sevda@sbu.ac.ir',
            'national_code' => '7520423991',
            'phone_number' => '09214129632',
            'user_type' => 'technical_support',
            'password' => '123456789',
        ]);

        $u4->assignRole('technical_support');

        $admin = User::create([
            'first_name' => 'اسلام',
            'last_name' => 'ناظمی',
            'email' => 'nazemi@gmail.com',
            'national_code' => '5632148541',
            'user_type' => 'admin',
            'password' => '12345678'
        ]);
    
        $admin->assignRole('admin');
    }
}
