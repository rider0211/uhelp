<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class Customcssjs extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customcssjs')->insert([[
            'name' => 'CUSTOMCHATENABLE',
            'value' => 'disable',
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'name' => 'CUSTOMCHATUSER',
            'value' => 'public',
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'CUSTOMCHAT',
            'value' => null,
            'created_at' => now(),
            'updated_at' => now()
        ],
        [
            'name' => 'CUSTOMJS',
            'value' => null,
            'created_at' => now(),
            'updated_at' => now()
        ],[
            'name' => 'CUSTOMCSS',
            'value' => null,
            'created_at' => now(),
            'updated_at' => now()
        ]
        ]);
    }
}
