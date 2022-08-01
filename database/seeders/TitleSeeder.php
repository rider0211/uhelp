<?php

namespace Database\Seeders;

use App\Models\Apptitle;
use App\Models\callaction;
use App\Models\FeatureBox;
use DB;


use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = Apptitle::create([

            'title' => env('APP_NAME'),
            'searchtitle' => 'Looking For help?',
            'searchsub' => 'Type your query or submit your ticket',

            'featurecheck' => 'on',
            'featuretitle' => 'Why Choose US?',
            'featuresub' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',

            'articlecheck' => 'on',
            'articletitle' => 'Check Out Recent Articles',
            'articlesub' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',

            'testimonialcheck' => 'on',
            'testimonialtitle' => 'Check Out Client Says',
            'testimonialsub' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
            
            'faqcheck' => 'on',
            'faqtitle' => 'Check Out FAQ’s',
            'faqsub' => 'Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',


        ]);


        $call = callaction::create([

            'callcheck' => 'on',
            'title'  => 'Need Support & Response within 24 hours?',
            'subtitle'  => 'Excepteur sint occaecat cupidatat non proident mollit anim id est laborum',
            'buttonname'  => 'Open Ticket',
            'image'  => null,
            'buttonurl'  => '#',
           

        ]);

        $box = FeatureBox::create([
            'title' => 'Secure Payment',
            'subtitle' => 'Nam libero tempore, cum soluta nobis est eligendi cumque facere possimus',
            'image' => null,
            
        ]);
        $box = FeatureBox::create([
            'title' => 'Quality Templates',
            'subtitle' => 'Nam libero tempore, cum soluta nobis est eligendi cumque facere possimus',
            'image' => null,
            
        ]);
        $box = FeatureBox::create([
            'title' => '24/7 Support',
            'subtitle' => 'Nam libero tempore, cum soluta nobis est eligendi cumque facere possimus',
            'image' => null,
            
        ]);


       
    }
}
