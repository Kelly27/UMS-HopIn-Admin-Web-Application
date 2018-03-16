<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AnnouncementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('announcements')->insert([
            'title' => 'Happy Chinese New Year',
            'content' => '<p>Our team wish all UMS staffs and student a very&nbsp;<strong>Happy New Year&nbsp;</strong>for the year of 2018. Wish all the best to everyone! Our bus service will operate as usual.</p><p><img src="http://www.ums.edu.my/v5/images/article-images/bus-tepi2.jpg" alt="" width="337" height="226" /></p>'
        ]);

        DB::table('announcements')->insert([
            'title' => 'Changes of bus schedule',
            'content' => '<p>Due to the exam week, please be noted that the bus schedule will be changed.</p>'
        ]);

        DB::table('announcements')->insert([
            'title' => 'Change of route',
            'content' => '<p>Due to coming Convocation, the bus route will change as follows:</p>
<p><img src="http://www.ums.edu.my/v5/images/article-images/bus-tepi2.jpg" alt="" width="337" height="226" /></p>
<p>Best regards.</p>'
        ]);
    }
}
