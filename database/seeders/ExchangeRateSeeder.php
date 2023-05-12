<?php

namespace Database\Seeders;

use App\Models\ExchangeRate;
use Illuminate\Database\Seeder;

class ExchangeRateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=ExchangeRateSeeder
     *
     * @return void
     */
    public function run()
    {
        ExchangeRate::firstOrCreate(['amount_usd' => '1','amount_riel' => '4065']);
    }
}
