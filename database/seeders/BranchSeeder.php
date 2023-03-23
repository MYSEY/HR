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
        Branchs::firstOrCreate(['branch_name_kh' => 'Head Office','branch_name_en'=> 'Head Office']);
        Branchs::firstOrCreate(['branch_name_kh' => 'Angksnuol','branch_name_en'=> 'Angksnuol']);
        Branchs::firstOrCreate(['branch_name_kh' => 'Takhmao','branch_name_en'=> 'Takhmao']);
        Branchs::firstOrCreate(['branch_name_kh' => 'Kong Pisei','branch_name_en'=> 'Kong Pisei']);
        Branchs::firstOrCreate(['branch_name_kh' => 'Kampong speu','branch_name_en'=> 'Kampong speu']);
    }
}
