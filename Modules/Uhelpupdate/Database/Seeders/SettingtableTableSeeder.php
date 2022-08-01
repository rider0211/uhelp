<?php

namespace Modules\Uhelpupdate\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use DB;

class SettingtableTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('settings')->insert([
            [
                'key' => 'ENVATO_ON',
                'value' => 'on',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
