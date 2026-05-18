<?php

namespace Database\Seeders;
use App\Models\AnnualSalaryIncreasement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AnnualSalaryIncreasementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=AnnualSalaryIncreasementSeeder
     *
     * @return void
     */
    public function run()
    {
        AnnualSalaryIncreasement::firstOrCreate([
            "ranking_work_result"=> "ខ្សោយ_(ក្រោមផែនការ២០%)",
            "total_score"=> "1 - 1.99",
            "percentage"=> "0",
            "increasement_year"=> "2026",
        ]);
        AnnualSalaryIncreasement::firstOrCreate([
            "ranking_work_result"=> "ត្រូវកែលម្អ_(ក្រោមផែនការ១០%)",
            "total_score"=> "2 - 2.99",
            "percentage"=> "1",
            "increasement_year"=> "2026",
        ]);
        AnnualSalaryIncreasement::firstOrCreate([
            "ranking_work_result"=> "ធម្យម_(អនុវត្តន៍ការងារគ្រប់ផែនការងារ)",
            "total_score"=> "3 - 3.99",
            "percentage"=> "2",
            "increasement_year"=> "2026",
        ]);
        AnnualSalaryIncreasement::firstOrCreate([
            "ranking_work_result"=> "ល្អ_(អនុវត្តន៍ការងារលើសផែនការងារ១០%)",
            "total_score"=> "4 - 4.69",
            "percentage"=> "3",
            "increasement_year"=> "2026",
        ]);
        AnnualSalaryIncreasement::firstOrCreate([
            "ranking_work_result"=> "ឆ្នើម_(អនុវត្តន៍ការងារលើសផែនការ២០%)",
            "total_score"=> "4.70 - 5",
            "percentage"=> "4",
            "increasement_year"=> "2026",
        ]);
    }
}
