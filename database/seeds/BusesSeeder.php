<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('buses')->insert([
            "bus_number" => '11',
            'plate_no' => 'SA5612A',
            'year_manufactured' => '2002',
            'track_status' => 'ON',
            'bus_location' => '{"lat":"6.030843690410314","lng":"116.1224618287165"}',
            'route_id' => 10,
        ]);

        DB::table('buses')->insert([
            "bus_number" => '1',
            'plate_no' => 'SA5112A',
            'year_manufactured' => '1994',
            'track_status' => 'ON',
            'bus_location' => '{"lat":6.040830210269516,"lng":116.12340596628974}',
            'route_id' => 7,
        ]);

        DB::table('buses')->insert([
            "bus_number" => '7',
            'plate_no' => 'SD9872A',
            'year_manufactured' => '2005',
            'track_status' => 'ON',
            'bus_location' => '{"lat":6.01048486,"lng":116.1009414}',
            'route_id' => 8,
        ]);
    }
}
