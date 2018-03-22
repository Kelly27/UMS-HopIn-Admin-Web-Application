<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DriverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('drivers')->insert([
            'name' => 'admin',
            'ic_number' => '912456-12-1256',
            'staff_number' => 'BI987654',
            'password' => '$2y$10$Ir0cc7EYMNLTTR4lmK0cAeiBQl5tpHSkCBWh/fYvqQ0E4J6wNfNPK',
        ]);
    }
}
