<?php

namespace Database\Seeders;
use App\Models\RentalBrand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RentalBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=RentalBrandSeeder
     *
     * @return void
     */
    public function run()
    {
        RentalBrand::firstOrCreate([
            "brand_name"=> "Other",
            "type"=> "0",
        ]);
    }
}
