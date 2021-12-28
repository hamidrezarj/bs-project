<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('votes')->insert([
            ['id' => '1', 'name' => 'بسیار ضعیف'],
            ['id' => '2', 'name' => 'ضعیف'],
            ['id' => '3', 'name' => 'متوسط'],
            ['id' => '4', 'name' => 'خوب'],
            ['id' => '5', 'name' => 'عالی'],
        ]);
    }
}
