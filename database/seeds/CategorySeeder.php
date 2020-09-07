<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('categories')->truncate();

        DB::table('categories')->insert([
            ['name' => 'Around the House','icon' =>'fas fa-home','description'=>'Relating to spending time at home, gardening, lawn care, DIY.','created_at' => Carbon::now()],
            ['name' => 'Art', 'icon' => 'fas fa-palette','description'=>'Becoming an artist, drawing, fine art.','created_at' => Carbon::now()],
            ['name' => 'Automotive', 'icon' => 'fas fa-car','description'=>'All about motorized vehicles:  repairing, enthusiasts, purchase recommendations, etc.','created_at' => Carbon::now()],
            ['name' => 'Career Advice', 'icon' => 'fas fa-chalkboard-teacher','description'=>'Choosing a career, mentoring, promotions, work politics.','created_at' => Carbon::now()],
            ['name' => 'Computers/Software', 'icon' => 'fas fa-desktop','description'=>'Troubleshooting, installing, building, implementing, analyzing and earning via Computers and Software.','created_at' => Carbon::now()],
            ['name' => 'Covid-19', 'icon' => 'fas fa-viruses','description'=>'The pandemic that has changed the world.','created_at' => Carbon::now()],
            ['name' => 'Design', 'icon' => 'fas fa-bezier-curve','description'=>'UX, Graphic Arts, Architecture.','created_at' => Carbon::now()],
            ['name' => 'Electronics/Machinery', 'icon' => 'fas fa-microchip','description'=>'Technology discussions related to componentry, building and maintaining machines, electronic gadgets and more.','created_at' => Carbon::now()],
            ['name' => 'Event Planning', 'icon' => 'far fa-calendar-alt','description'=>'Weddings, corporate retreats, festivals, formals.','created_at' => Carbon::now()],
            ['name' => 'Games', 'icon' => 'fab fa-playstation','description'=>'Boardgames, Console, Retro, PC/Mac Games.','created_at' => Carbon::now()],
            ['name' => 'Home Improvement', 'icon' => 'fas fa-hammer','description'=>'Fixing, improving, replacing, DIY Projects.','created_at' => Carbon::now()],
            ['name' => 'Investing', 'icon' => 'fas fa-comment-dollar','description'=>'Taxes, 401Ks, Accounting.','created_at' => Carbon::now()],
            ['name' => 'Leadership', 'icon' => 'fab fa-critical-role','description'=>'Coaching, teamwork, culture, remote teams.','created_at' => Carbon::now()],
            ['name' => 'Music', 'icon' => 'fas fa-music','description'=>'Learning to play, recording your music, teaching music.','created_at' => Carbon::now()],
            ['name' => 'New Tech', 'icon' => 'fab fa-battle-net','description'=>'Emerging and horizon technology areas - e.g. AI, AR/VR, Autonomous Vehicles.','created_at' => Carbon::now()],
            ['name' => 'Parenting', 'icon' => 'fas fa-baby-carriage','description'=>'Everything related to parenthood from babies to adult children.','created_at' => Carbon::now()],
            ['name' => 'Pets', 'icon' => 'fas fa-dog','description'=>'Ownership topics including raising, training, dogs, cats, small pets, hamsters, guinea pigs, snakes, etc.','created_at' => Carbon::now()],
            ['name' => 'Relationships', 'icon' => 'fas fa-user-friends','description'=>'Friends, dating, marriage, work, family.','created_at' => Carbon::now()],
            ['name' => 'Travel', 'icon' => 'fas fa-caravan','description'=>'International travel, very local travel, exotic destinations, working with travel agencies.','created_at' => Carbon::now()],
            ['name' => 'Writing', 'icon' => 'fas fa-paragraph','description'=>'How to become an author, poetry, digital media, print.','created_at' => Carbon::now()],
        ]);

    }
}
