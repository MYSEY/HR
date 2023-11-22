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
            'address' => '#101A, St. 289, Sangkat Boeung Kak 1, Khan Toul Kork, Phnom Penh, Cambodia',
            'address_kh'    => 'ផ្ទះ​លេខ​១០១អា ផ្លូវ​២៨៩ សង្កាត់បឹងកក់ទី១ ខណ្ឌទួលគោក រាជធានីភ្នំពេញ'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'ការិយាល័យប្រតិបត្តិការ',
            'branch_name_en'=> 'Operation Unit',
            'abbreviations' => 'HO',
            'address' => '#101A, St. 289, Sangkat Boeung Kak 1, Khan Toul Kork, Phnom Penh, Cambodia',
            'address_kh'    => 'ផ្ទះ​លេខ​១០១អា ផ្លូវ​២៨៩ សង្កាត់បឹងកក់ទី១ ខណ្ឌទួលគោក រាជធានីភ្នំពេញ'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាស្រុកអង្គស្នួល',
            'branch_name_en'=> 'Angsnoul Branch',
            'abbreviations' => 'ANS',
            'address' => '#38A1, National Road 4, Svay Chrum Village, Baek Chan, Angksnoul District, Kandal',
            'address_kh'    => 'ផ្ទះលេខ ៣៨អា១ ផ្លូវជាតិលេខ៤ ភូមិស្វាយជ្រុំ ឃុំបែកចាន ស្រុកអង្គស្នួល ខេត្តកណ្ដាល'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាក្រុងតាខ្មៅ',
            'branch_name_en'=> 'Takmao Branch',
            'abbreviations' => 'TKM',
            'address' => '#115, Prek Samraong Village,Sangkat Ta Khmao, Krong Ta Khmao, Kandal',
            'address_kh'    => 'ផ្លូវ​លេខ ១១៥ ភូមិ​ព្រែក​សំរោង សង្កាត់តាខ្មៅ ក្រុងតាខ្មៅ ខេត្តកណ្ដាល'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាគងពិសី',
            'branch_name_en'=> 'Kongpisei Branch',
            'abbreviations' => 'KPB',
            'address' => 'House #A7, National Road #3, Krabeitram Village, Chrok Commune, Kong Pisei District, Kampong Speu Province',
            'address_kh'    => 'ផ្ទះលេខ អា៧ ផ្លូវជាតិលេខ៣ ភូមិក្របីត្រាំ ឃុំជង្រុក ស្រុកគងពិសី ខេត្តកំពង់ស្ពឺ'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'កំពង់ស្ពឺ',
            'branch_name_en'=> 'Kampong Speu',
            'abbreviations' => 'KPS',
            'address' => 'National Road No.4, Phum Krang Pol Tep, Sangkat Rokar Thum, Krong Chbar Mon, Kampong Speu Province.',
            'address_kh'    => 'ផ្លូវជាតិលេខ៤ ភូមិក្រាំងពលទេព សង្កាត់រការធំ ក្រុងច្បារមន ខេត្តកំពង់ស្ពឺ'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាស្អាង',
            'branch_name_en'=> 'Sa-Ang Branch',
            'abbreviations' => 'SAB',
            'address' => 'National Road No.21, Traeuy Troeng Village, Preaek Ambel Commune, S’ang District, Kandal Province',
            'address_kh'    => 'ផ្លូវជាតិលេខ២១ ភូមិត្រើយត្រឹង្ស ឃុំព្រែកអំបិល ស្រុកស្អាង ខេត្តកណ្ដាល'
        ]);
        Branchs::firstOrCreate([
            'branch_name_kh' => 'សាខាកំពង់ត្រាច',
            'branch_name_en'=> 'Kompong Trach',
            'abbreviations' => 'KTB',
            'address' => 'National Road No.33, Kampong Trach Ti Pir Village, Kampong Trach Khang Lech Commune, Kampong Trach District, Kampot Province',
            'address_kh'    => 'ផ្លូវជាតិលេខ៣៣ ភូមិកំពង់ត្រាចទី២ ឃុំកំពង់ត្រាចខាងលិច ស្រុកកំពង់ត្រាច ខេត្តកំពត'
        ]);
    }
}
