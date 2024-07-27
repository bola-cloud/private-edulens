<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorates = [
            ['name' => 'Alexandria'],
            ['name' => 'Aswan'],
            ['name' => 'Asyut'],
            ['name' => 'Beheira'],
            ['name' => 'Beni Suef'],
            ['name' => 'Cairo'],
            ['name' => 'Dakahlia'],
            ['name' => 'Damietta'],
            ['name' => 'Faiyum'],
            ['name' => 'Gharbia'],
            ['name' => 'Giza'],
            ['name' => 'Ismailia'],
            ['name' => 'Kafr El Sheikh'],
            ['name' => 'Luxor'],
            ['name' => 'Matrouh'],
            ['name' => 'Minya'],
            ['name' => 'Monufia'],
            ['name' => 'New Valley'],
            ['name' => 'North Sinai'],
            ['name' => 'Port Said'],
            ['name' => 'Qalyubia'],
            ['name' => 'Qena'],
            ['name' => 'Red Sea'],
            ['name' => 'Sharqia'],
            ['name' => 'Sohag'],
            ['name' => 'South Sinai'],
            ['name' => 'Suez'],
        ];

        // Insert data into the database
        DB::table('governorates')->insert($governorates);
    }
}
