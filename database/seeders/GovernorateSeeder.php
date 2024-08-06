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
            ['name' => 'الإسكندرية'], // Alexandria
            ['name' => 'أسوان'], // Aswan
            ['name' => 'أسيوط'], // Asyut
            ['name' => 'البحيرة'], // Beheira
            ['name' => 'بني سويف'], // Beni Suef
            ['name' => 'القاهرة'], // Cairo
            ['name' => 'الدقهلية'], // Dakahlia
            ['name' => 'دمياط'], // Damietta
            ['name' => 'الفيوم'], // Faiyum
            ['name' => 'الغربية'], // Gharbia
            ['name' => 'الجيزة'], // Giza
            ['name' => 'الإسماعيلية'], // Ismailia
            ['name' => 'كفر الشيخ'], // Kafr El Sheikh
            ['name' => 'الأقصر'], // Luxor
            ['name' => 'مطروح'], // Matrouh
            ['name' => 'المنيا'], // Minya
            ['name' => 'المنوفية'], // Monufia
            ['name' => 'الوادي الجديد'], // New Valley
            ['name' => 'شمال سيناء'], // North Sinai
            ['name' => 'بورسعيد'], // Port Said
            ['name' => 'القليوبية'], // Qalyubia
            ['name' => 'قنا'], // Qena
            ['name' => 'البحر الأحمر'], // Red Sea
            ['name' => 'الشرقية'], // Sharqia
            ['name' => 'سوهاج'], // Sohag
            ['name' => 'جنوب سيناء'], // South Sinai
            ['name' => 'السويس'], // Suez
        ];
        
        // Insert data into the database
        DB::table('governorates')->insert($governorates);
        
    }
}
