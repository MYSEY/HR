<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=ProvinceSeeder
     *
     * @return void
     */
    public function run()
    {
        Province::firstOrCreate([
            "code"=> "01",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "បន្ទាយមានជ័យ",
            "name_latin"=> "Banteay Meanchey",
            "name_en"=> "Banteay Meanchey",
            "full_name_km"=> "ខេត្តបន្ទាយមានជ័យ",
            "full_name_latin"=> "Khaet Banteay Meanchey",
            "full_name_en"=> "Banteay Meanchey Province",
            "address_km"=> "ខេត្តបន្ទាយមានជ័យ",
            "address_latin"=> "Khaet Banteay Meanchey",
            "address_en"=> "Banteay Meanchey Province"
        ]);
        Province::firstOrCreate([
            "code"=> "02",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "បាត់ដំបង",
            "name_latin"=> "Battambang",
            "name_en"=> "Battambang",
            "full_name_km"=> "ខេត្តបាត់ដំបង",
            "full_name_latin"=> "Khaet Battambang",
            "full_name_en"=> "Battambang Province",
            "address_km"=> "ខេត្តបាត់ដំបង",
            "address_latin"=> "Khaet Battambang",
            "address_en"=> "Battambang Province"
        ]);
        Province::firstOrCreate([
            "code"=> "03",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "កំពង់ចាម",
            "name_latin"=> "Kampong Cham",
            "name_en"=> "Kampong Cham",
            "full_name_km"=> "ខេត្តកំពង់ចាម",
            "full_name_latin"=> "Khaet Kampong Cham",
            "full_name_en"=> "Kampong Cham Province",
            "address_km"=> "ខេត្តកំពង់ចាម",
            "address_latin"=> "Khaet Kampong Cham",
            "address_en"=> "Kampong Cham Province"
        ]);
        Province::firstOrCreate([
            "code"=> "04",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "កំពង់ឆ្នាំង",
            "name_latin"=> "Kampong Chhnang",
            "name_en"=> "Kampong Chhnang",
            "full_name_km"=> "ខេត្តកំពង់ឆ្នាំង",
            "full_name_latin"=> "Khaet Kampong Chhnang",
            "full_name_en"=> "Kampong Chhnang Province",
            "address_km"=> "ខេត្តកំពង់ឆ្នាំង",
            "address_latin"=> "Khaet Kampong Chhnang",
            "address_en"=> "Kampong Chhnang Province"
        ]);
        Province::firstOrCreate([
            "code"=> "05",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "កំពង់ស្ពឺ",
            "name_latin"=> "Kampong Speu",
            "name_en"=> "Kampong Speu",
            "full_name_km"=> "ខេត្តកំពង់ស្ពឺ",
            "full_name_latin"=> "Khaet Kampong Speu",
            "full_name_en"=> "Kampong Speu Province",
            "address_km"=> "ខេត្តកំពង់ស្ពឺ",
            "address_latin"=> "Khaet Kampong Speu",
            "address_en"=> "Kampong Speu Province"
        ]);
        Province::firstOrCreate([
            "code"=> "06",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "កំពង់ធំ",
            "name_latin"=> "Kampong Thom",
            "name_en"=> "Kampong Thom",
            "full_name_km"=> "ខេត្តកំពង់ធំ",
            "full_name_latin"=> "Khaet Kampong Thom",
            "full_name_en"=> "Kampong Thom Province",
            "address_km"=> "ខេត្តកំពង់ធំ",
            "address_latin"=> "Khaet Kampong Thom",
            "address_en"=> "Kampong Thom Province"
        ]);
        Province::firstOrCreate([
            "code"=> "07",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "កំពត",
            "name_latin"=> "Kampot",
            "name_en"=> "Kampot",
            "full_name_km"=> "ខេត្តកំពត",
            "full_name_latin"=> "Khaet Kampot",
            "full_name_en"=> "Kampot Province",
            "address_km"=> "ខេត្តកំពត",
            "address_latin"=> "Khaet Kampot",
            "address_en"=> "Kampot Province"
        ]);
        Province::firstOrCreate([
            "code"=> "08",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "កណ្ដាល",
            "name_latin"=> "Kandal",
            "name_en"=> "Kandal",
            "full_name_km"=> "ខេត្តកណ្ដាល",
            "full_name_latin"=> "Khaet Kandal",
            "full_name_en"=> "Kandal Province",
            "address_km"=> "ខេត្តកណ្ដាល",
            "address_latin"=> "Khaet Kandal",
            "address_en"=> "Kandal Province"
        ]);
        Province::firstOrCreate([
            "code"=> "09",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "កោះកុង",
            "name_latin"=> "Koh Kong",
            "name_en"=> "Koh Kong",
            "full_name_km"=> "ខេត្តកោះកុង",
            "full_name_latin"=> "Khaet Koh Kong",
            "full_name_en"=> "Koh Kong Province",
            "address_km"=> "ខេត្តកោះកុង",
            "address_latin"=> "Khaet Koh Kong",
            "address_en"=> "Koh Kong Province"
        ]);
        Province::firstOrCreate([
            "code"=> "10",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "ក្រចេះ",
            "name_latin"=> "Kratie",
            "name_en"=> "Kratie",
            "full_name_km"=> "ខេត្តក្រចេះ",
            "full_name_latin"=> "Khaet Kratie",
            "full_name_en"=> "Kratie Province",
            "address_km"=> "ខេត្តក្រចេះ",
            "address_latin"=> "Khaet Kratie",
            "address_en"=> "Kratie Province"
        ]);
        Province::firstOrCreate([
            "code"=> "11",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "មណ្ឌលគិរី",
            "name_latin"=> "Mondul Kiri",
            "name_en"=> "Mondul Kiri",
            "full_name_km"=> "ខេត្តមណ្ឌលគិរី",
            "full_name_latin"=> "Khaet Mondul Kiri",
            "full_name_en"=> "Mondul Kiri Province",
            "address_km"=> "ខេត្តមណ្ឌលគិរី",
            "address_latin"=> "Khaet Mondul Kiri",
            "address_en"=> "Mondul Kiri Province"
        ]);
        Province::firstOrCreate([
            "code"=> "12",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "ភ្នំពេញ",
            "name_latin"=> "Phnom Penh",
            "name_en"=> "Phnom Penh",
            "full_name_km"=> "រាជធានីភ្នំពេញ",
            "full_name_latin"=> "Reach Theani Phnom Penh",
            "full_name_en"=> "Phnom Penh Capital",
            "address_km"=> "រាជធានីភ្នំពេញ",
            "address_latin"=> "Reach Theani Phnom Penh",
            "address_en"=> "Phnom Penh Capital"
        ]);
        Province::firstOrCreate([
            "code"=> "13",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "ព្រះវិហារ",
            "name_latin"=> "Preah Vihear",
            "name_en"=> "Preah Vihear",
            "full_name_km"=> "ខេត្តព្រះវិហារ",
            "full_name_latin"=> "Khaet Preah Vihear",
            "full_name_en"=> "Preah Vihear Province",
            "address_km"=> "ខេត្តព្រះវិហារ",
            "address_latin"=> "Khaet Preah Vihear",
            "address_en"=> "Preah Vihear Province"
        ]);
        Province::firstOrCreate([
            "code"=> "14",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "ព្រៃវែង",
            "name_latin"=> "Prey Veng",
            "name_en"=> "Prey Veng",
            "full_name_km"=> "ខេត្តព្រៃវែង",
            "full_name_latin"=> "Khaet Prey Veng",
            "full_name_en"=> "Prey Veng Province",
            "address_km"=> "ខេត្តព្រៃវែង",
            "address_latin"=> "Khaet Prey Veng",
            "address_en"=> "Prey Veng Province"
        ]);
        Province::firstOrCreate([
            "code"=> "15",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "ពោធិ៍សាត់",
            "name_latin"=> "Pursat",
            "name_en"=> "Pursat",
            "full_name_km"=> "ខេត្តពោធិ៍សាត់",
            "full_name_latin"=> "Khaet Pursat",
            "full_name_en"=> "Pursat Province",
            "address_km"=> "ខេត្តពោធិ៍សាត់",
            "address_latin"=> "Khaet Pursat",
            "address_en"=> "Pursat Province"
        ]);
        Province::firstOrCreate([
            "code"=> "16",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "រតនគិរី",
            "name_latin"=> "Ratanak Kiri",
            "name_en"=> "Ratanak Kiri",
            "full_name_km"=> "ខេត្តរតនគិរី",
            "full_name_latin"=> "Khaet Ratanak Kiri",
            "full_name_en"=> "Ratanak Kiri Province",
            "address_km"=> "ខេត្តរតនគិរី",
            "address_latin"=> "Khaet Ratanak Kiri",
            "address_en"=> "Ratanak Kiri Province"
        ]);
        Province::firstOrCreate([
            "code"=> "17",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "សៀមរាប",
            "name_latin"=> "Siemreap",
            "name_en"=> "Siemreap",
            "full_name_km"=> "ខេត្តសៀមរាប",
            "full_name_latin"=> "Khaet Siemreap",
            "full_name_en"=> "Siemreap Province",
            "address_km"=> "ខេត្តសៀមរាប",
            "address_latin"=> "Khaet Siemreap",
            "address_en"=> "Siemreap Province"
        ]);
        Province::firstOrCreate([
            "code"=> "18",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "ព្រះសីហនុ",
            "name_latin"=> "Preah Sihanouk",
            "name_en"=> "Preah Sihanouk",
            "full_name_km"=> "ខេត្តព្រះសីហនុ",
            "full_name_latin"=> "Khaet Preah Sihanouk",
            "full_name_en"=> "Preah Sihanouk Province",
            "address_km"=> "ខេត្តព្រះសីហនុ",
            "address_latin"=> "Khaet Preah Sihanouk",
            "address_en"=> "Preah Sihanouk Province"
        ]);
        Province::firstOrCreate([
            "code"=> "19",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "ស្ទឹងត្រែង",
            "name_latin"=> "Stung Treng",
            "name_en"=> "Stung Treng",
            "full_name_km"=> "ខេត្តស្ទឹងត្រែង",
            "full_name_latin"=> "Khaet Stung Treng",
            "full_name_en"=> "Stung Treng Province",
            "address_km"=> "ខេត្តស្ទឹងត្រែង",
            "address_latin"=> "Khaet Stung Treng",
            "address_en"=> "Stung Treng Province"
        ]);
        Province::firstOrCreate([
            "code"=> "20",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "ស្វាយរៀង",
            "name_latin"=> "Svay Rieng",
            "name_en"=> "Svay Rieng",
            "full_name_km"=> "ខេត្តស្វាយរៀង",
            "full_name_latin"=> "Khaet Svay Rieng",
            "full_name_en"=> "Svay Rieng Province",
            "address_km"=> "ខេត្តស្វាយរៀង",
            "address_latin"=> "Khaet Svay Rieng",
            "address_en"=> "Svay Rieng Province"
        ]);
        Province::firstOrCreate([
            "code"=> "21",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "តាកែវ",
            "name_latin"=> "Takeo",
            "name_en"=> "Takeo",
            "full_name_km"=> "ខេត្តតាកែវ",
            "full_name_latin"=> "Khaet Takeo",
            "full_name_en"=> "Takeo Province",
            "address_km"=> "ខេត្តតាកែវ",
            "address_latin"=> "Khaet Takeo",
            "address_en"=> "Takeo Province"
        ]);
        Province::firstOrCreate([
            "code"=> "22",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "ឧត្ដរមានជ័យ",
            "name_latin"=> "Oddar Meanchey",
            "name_en"=> "Oddar Meanchey",
            "full_name_km"=> "ខេត្តឧត្ដរមានជ័យ",
            "full_name_latin"=> "Khaet Oddar Meanchey",
            "full_name_en"=> "Oddar Meanchey Province",
            "address_km"=> "ខេត្តឧត្ដរមានជ័យ",
            "address_latin"=> "Khaet Oddar Meanchey",
            "address_en"=> "Oddar Meanchey Province"
        ]);
        Province::firstOrCreate([
            "code"=> "23",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "កែប",
            "name_latin"=> "Kep",
            "name_en"=> "Kep",
            "full_name_km"=> "ខេត្តកែប",
            "full_name_latin"=> "Khaet Kep",
            "full_name_en"=> "Kep Province",
            "address_km"=> "ខេត្តកែប",
            "address_latin"=> "Khaet Kep",
            "address_en"=> "Kep Province"
        ]);
        Province::firstOrCreate([
            "code"=> "24",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "ប៉ៃលិន",
            "name_latin"=> "Pailin",
            "name_en"=> "Pailin",
            "full_name_km"=> "ខេត្តប៉ៃលិន",
            "full_name_latin"=> "Khaet Pailin",
            "full_name_en"=> "Pailin Province",
            "address_km"=> "ខេត្តប៉ៃលិន",
            "address_latin"=> "Khaet Pailin",
            "address_en"=> "Pailin Province"
        ]);
        Province::firstOrCreate([
            "code"=> "25",
            "khaet_name_km"=> "ខេត្ត",
            "khaet_name_latin"=> "Khaet",
            "khaet_name_en"=> "Province",
            "name_km"=> "ត្បូងឃ្មុំ",
            "name_latin"=> "Tboung Khmum",
            "name_en"=> "Tboung Khmum",
            "full_name_km"=> "ខេត្តត្បូងឃ្មុំ",
            "full_name_latin"=> "Khaet Tboung Khmum",
            "full_name_en"=> "Tboung Khmum Province",
            "address_km"=> "ខេត្តត្បូងឃ្មុំ",
            "address_latin"=> "Khaet Tboung Khmum",
            "address_en"=> "Tboung Khmum Province"
        ]);
    }
}
