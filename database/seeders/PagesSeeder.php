<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pages')->insert([[
            'pageslug' => 'privacy-policy',
            'pagename' => 'Privacy Policy',
            'pagedescription' => 'At WEBSITE NAME, accessible at http://yourwebsite.com, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by WEBSITE NAME and how we use it.',
            'created_at' => now(),
            'updated_at' => now()
        ], [
            'pageslug' => 'terms',
            'pagename' => 'Terms of Use',
            'pagedescription' => 'At WEBSITE NAME, accessible at http://yourwebsite.com, one of our main priorities is the privacy of our visitors. This Privacy Policy document contains types of information that is collected and recorded by WEBSITE NAME and how we use it.',
            'created_at' => now(),
            'updated_at' => now()
        ],
    ]);

    }
}
