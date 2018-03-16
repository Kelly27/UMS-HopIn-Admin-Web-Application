<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AnnouncementSeeder::class);
        $this->call(BusesSeeder::class);
        $this->call(BusStopsSeeder::class);
        $this->call(DriverSeeder::class);
        $this->call(RoutesSeeder::class);

        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@umshopin.com',
            'password' => '$2y$10$K9Une8lKzV9AnTpoT2Xbzu2s3pJENqjridJlQ5oJ8himBwJdSb7a6',
            'remember_token' => '9sjCvvrhKTjU1XRCTZSZpeJB5G2fFYw3aMb5F7XTFFShUidO4fgibB55hnYl'
        ]);
    }
}
