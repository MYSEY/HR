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
            'branch_name_kh' => 'Head Quarter',
            'branch_name_en'=> 'ការិយាល័យកណ្តាល',
            'abbreviations' => 'HQ'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'Operation Unit',
            'branch_name_en'=> 'ការិយាល័យប្រតិបត្តិការ',
            'abbreviations' => 'HO'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'Angsnoul Branch',
            'branch_name_en'=> 'សាខាស្រុកអង្គស្នួល',
            'abbreviations' => 'ANS'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'Takmao Branch',
            'branch_name_en'=> 'សាខាក្រុងតាខ្មៅ',
            'abbreviations' => 'TKM'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'Kongpisei Branch',
            'branch_name_en'=> 'សាខាគងពិសី',
            'abbreviations' => 'KPB'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'Kampong Speu',
            'branch_name_en'=> 'កំពង់ស្ពឺ',
            'abbreviations' => 'KPS'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'Sa-Ang Branch',
            'branch_name_en'=> 'សាខាស្អាង',
            'abbreviations' => 'SAB'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'Kompong Trach',
            'branch_name_en'=> 'សាខាកំពង់ត្រាច',
            'abbreviations' => 'KTB'
        ]);
    }
}
