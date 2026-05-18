<?php

namespace Database\Seeders;
use App\Models\AnnualBonu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnualBonuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=AnnualBonuSeeder
     *
     * @return void
     */
    public function run()
    {
        AnnualBonu::firstOrCreate([
            "criteria"=> "3.1",
            "discription"=> "Unsatisfactory",
            "total_score"=> "ពិន្ទុ  (ក្រោម ឬស្មើ 1.99)",
            "percentage"=> "0",
            "increasement_year"=> "2026",
        ]);
        AnnualBonu::firstOrCreate([
            "criteria"=> "3.2",
            "discription"=> "Improvement Needed",
            "total_score"=> "ពិន្ទុ 2  (ពី2 ដល់ 2.99)",
            "percentage"=> "70",
            "increasement_year"=> "2026",
        ]);
        AnnualBonu::firstOrCreate([
            "criteria"=> "3.3",
            "discription"=> "Meet Expectations",
            "total_score"=> "ពិន្ទុ 3  (ពី3 ដល់ 3.99)",
            "percentage"=> "80",
            "increasement_year"=> "2026",
        ]);
        AnnualBonu::firstOrCreate([
            "criteria"=> "3.4",
            "discription"=> "Exceeds Expectations",
            "total_score"=> "ពិន្ទុ 4  (ពី4 ដល់ 4.69)",
            "percentage"=> "90",
            "increasement_year"=> "2026",
        ]);
        AnnualBonu::firstOrCreate([
            "criteria"=> "3.5",
            "discription"=> "Outstanding",
            "total_score"=> "ពិន្ទុ 5  (ពី4.70 ដល់ 5)",
            "percentage"=> "100",
            "increasement_year"=> "2026",
        ]);
    }
}
