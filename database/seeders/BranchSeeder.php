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
            'abbreviations' => 'HQ'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'ការិយាល័យប្រតិបត្តិការ',
            'branch_name_en'=> 'Operation Unit',
            'abbreviations' => 'HO'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាស្រុកអង្គស្នួល',
            'branch_name_en'=> 'Angsnoul Branch',
            'abbreviations' => 'ANS'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាក្រុងតាខ្មៅ',
            'branch_name_en'=> 'Takmao Branch',
            'abbreviations' => 'TKM'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាគងពិសី',
            'branch_name_en'=> 'Kongpisei Branch',
            'abbreviations' => 'KPB'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'កំពង់ស្ពឺ',
            'branch_name_en'=> 'Kampong Speu',
            'abbreviations' => 'KPS'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាស្អាង',
            'branch_name_en'=> 'Sa-Ang Branch',
            'abbreviations' => 'SAB'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាកំពង់ត្រាច',
            'branch_name_en'=> 'Kompong Trach',
            'abbreviations' => 'KTB'
        ]);
    }
}
