<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Testimonial::create([
            'name' => 'Heather Bell',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quod eos id officiis hic tenetur quae quaerat ad velit ab. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore cum accusamus eveniet molestias voluptatum inventore laboriosam labore sit, aspernatur praesentium iste impedit quidem dolor veniam.',
            'designation' => 'Developer',
            'created_at' => '2022-01-07 06:13:30',
            'updated_at' => '2022-01-07 06:13:30',

        ]);

        Testimonial::create([
            'name' => 'David Blake',
            'description' => 'Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore.',
            'designation' => 'Designer',
            'created_at' => '2022-01-07 06:13:30',
            'updated_at' => '2022-01-07 06:13:30',

        ]);

        Testimonial::create([
            'name' => 'Sophie Carr',
            'description' => 'Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.',
            'designation' => 'HTML',
            'created_at' => '2022-01-07 06:13:30',
            'updated_at' => '2022-01-07 06:13:30',

        ]);
       
    }
}
