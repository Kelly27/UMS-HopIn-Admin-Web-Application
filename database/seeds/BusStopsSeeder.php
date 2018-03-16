<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusStopsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bus_stops')->insert([
            'name' => 'Library',
            'description' => '<p>Bus stop near the UMS Library.</p>',
            'location' =>'{"lat":6.03342803289023,"lng":116.11814176120765}'
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'PPIB',
            'description' => '<p>Bus stop near <em>PPIB</em>.</p>',
            'location' => '{"lat":6.032867854980356,"lng":116.11752683832253}'
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'FKSW',
            'description' => '<p>Bus Stop near FKSW</p>',
            'location' => '{"lat":6.032836250036709,"lng":116.11359921386179}'
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'DKP Lama',
            'description' => '<p>Bus stop near DKP Lama</p>',
            'location' => '{"lat":6.0328095616929485,"lng":116.1146656599982}'
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'FKJ',
            'description' => '<p>Bus stop near FKJ</p>',
            'location' => '{"lat":6.036384280344619,"lng":116.1211546892489}'
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'Gate 1',
            'description' => '<p>Bus stop near the UMS gate</p>',
            'location' => '{"lat":6.033684344768686,"lng":116.12230393069854}'
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'Gate2',
            'description' => '<p>Bus Stop near gate of UMS</p>',
            'location' => '{"lat":6.033278661182031,"lng":116.12247621097572}'
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'Anjung Siswa',
            'description' => '<p>Bus Stop near Anjung Siswa</p>' ,
            'location' => '{"lat":6.036670150349585,"lng":116.12117240609996}'
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'Tun Mustapha (AB)' ,
            'description' => '<p>Bus stop near Koleh Kediaman Tun Mustapha(AB).</p>',
            'location' => '{"lat":6.039775715217775,"lng":116.12391987687124}'
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'Mosque' ,
            'description' => '<p>Bus stop near the UMS Mosque</p>' ,
            'location' => '{"lat":6.039460607778538,"lng":116.12407918177769}'
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'ABCD' ,
            'description' => '<p>Bus stop near ABCD (to Library)</p>' ,
            'location' => '{"lat":6.0409714097854925,"lng":116.12466164372745}'
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'Kolej Kediaman E (to DKP Baru)' ,
            'description' => '<p>bus stop near Kolej Kediaman E (to DKP Baru)</p>' ,
            'location' => '{"lat":6.045352641576667,"lng":116.12800093902604}'
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'Kolej Kediaman E (to Library)' ,
            'description' => '<p>Bus stop Kolej Kediaman E (to Library)</p>' ,
            'location' => ''
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'DKP Baru (end)' ,
            'description' => '<p>Bus Stop near DKP Baru (end of route.)</p>' ,
            'location' => '{"lat":6.045286043754284,"lng":116.1299543450084}'
        ]);

        DB::table('bus_stops')->insert([
            'name' => 'DKP Baru (begin)' ,
            'description' => '<p>Bus stop near DKP Baru (begin of route)</p>' ,
            'location' => '{"lat":6.045196309428384,"lng":116.13019947330247}'
        ]);
    }
}
