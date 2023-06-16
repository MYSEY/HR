<?php

namespace Database\Seeders;

use App\Models\Branchs;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=BranchSeeder
     *
     * @return void
     */
    public function run()
    {
        Branchs::firstOrCreate([
            'branch_name_kh' => 'ការិយាល័យកណ្តាល',
            'branch_name_en'=> 'Head Quarter',
            'abbreviations' => 'HQ',
            'address' => '#101A, St. 289, Sangkat Boeung Kak 1, Khan Toul Kork, Phnom Penh, Cambodia'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'ការិយាល័យប្រតិបត្តិការ',
            'branch_name_en'=> 'Operation Unit',
            'abbreviations' => 'HO',
            'address' => '#101A, St. 289, Sangkat Boeung Kak 1, Khan Toul Kork, Phnom Penh, Cambodia'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាស្រុកអង្គស្នួល',
            'branch_name_en'=> 'Angsnoul Branch',
            'abbreviations' => 'ANS',
            'address' => '#38A1, National Road 4, Svay Chrum Village, Baek Chan, Angksnoul District, Kandal'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាក្រុងតាខ្មៅ',
            'branch_name_en'=> 'Takmao Branch',
            'abbreviations' => 'TKM',
            'address' => '#115, Prek Samraong Village,Sangkat Ta Khmao, Krong Ta Khmao, Kandal'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាគងពិសី',
            'branch_name_en'=> 'Kongpisei Branch',
            'abbreviations' => 'KPB',
            'address' => 'House #A7, National Road #3, Krabeitram Village, Chrok Commune, Kong Pisei District, Kampong Speu Province'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'កំពង់ស្ពឺ',
            'branch_name_en'=> 'Kampong Speu',
            'abbreviations' => 'KPS',
            'address' => 'Kampong Speu Province'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាស្អាង',
            'branch_name_en'=> 'Sa-Ang Branch',
            'abbreviations' => 'SAB',
            'address' => ''
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាកំពង់ត្រាច',
            'branch_name_en'=> 'Kompong Trach',
            'abbreviations' => 'KTB',
            'address' => ''
        ]);
    }
}
