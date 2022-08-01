<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB; 

class FootertextSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('footertexts')->insert([
            'copyright' => '<p class="mb-0">Copyright © 2022 <a href="https://uhelp.spruko.com/"> Uhelp </a>. Developed by <a href="https://spruko.com/">Spruko Technologies</a></p>',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
