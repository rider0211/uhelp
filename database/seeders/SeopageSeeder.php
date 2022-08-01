<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB; 

class SeopageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('seosettings')->insert([
            'author' => 'My Desk',
            'description' => 'Looking For help?',
            'keywords' =>'Why Choose US ?',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
