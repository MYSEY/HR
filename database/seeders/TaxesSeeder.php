<?php

namespace Database\Seeders;

use App\Models\Taxes;
use Illuminate\Database\Seeder;

class TaxesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=TaxesSeeder
     *
     * @return void
     */
    public function run()
    {
        Taxes::firstOrCreate(['tax_rate' => '0','from' => '0','to'=>'1500000','tax_deduction_amount'=>'0']);
        Taxes::firstOrCreate(['tax_rate' => '5','from' => '1500001','to'=>'2000000','tax_deduction_amount'=>'75000']);
        Taxes::firstOrCreate(['tax_rate' => '10','from' => '2000001','to'=>'8500000','tax_deduction_amount'=>'175000']);
        Taxes::firstOrCreate(['tax_rate' => '15','from' => '8500001','to'=>'12500000','tax_deduction_amount'=>'600000']);
        Taxes::firstOrCreate(['tax_rate' => '20','from' => '12500001','to'=>'','tax_deduction_amount'=>'1225000']);
    }
}
