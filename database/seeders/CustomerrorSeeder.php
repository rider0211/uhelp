<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Str;
class CustomerrorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customizeerrors')->insert([[
            'errorname' => '404title',
            'errorvalue' => Str::title('Page Not Found'),
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'errorname' => '404subtitle',
            'errorvalue' => Str::ucfirst('Request Page Does Not Exists'),
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'errorname' => '503title',
            'errorvalue' => Str::title('MAINTENANCE MODE'),
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'errorname' => '503subtitle',
            'errorvalue' => Str::ucfirst('we will be back soon'),
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'errorname' => '503description',
            'errorvalue' => Str::ucfirst('please wait this site is undermaintenance'),
            'created_at' => now(),
            'updated_at' => now()
        ]
        ]);
    }
}
