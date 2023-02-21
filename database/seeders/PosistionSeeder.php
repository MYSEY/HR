<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PosistionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=PosistionSeeder
     *
     * @return void
     */
    public function run()
    {
        Position::firstOrCreate(['name_khmer' => 'Board of Director','name_english' => 'Board of Director']);
        Position::firstOrCreate(['name_khmer' => 'Chief Executive Officer','name_english' => 'Chief Executive Officer']);
        Position::firstOrCreate(['name_khmer' => 'Human Resources and Admin Department','name_english' => 'Human Resources and Admin Department']);
        Position::firstOrCreate(['name_khmer' => 'Accounting and Finance Department','name_english' => 'Accounting and Finance Department']);
        Position::firstOrCreate(['name_khmer' => 'IT Department','name_english' => 'IT Department']);
        Position::firstOrCreate(['name_khmer' => 'Credit Department','name_english' => 'Credit Department']);
        Position::firstOrCreate(['name_khmer' => 'Marketing and Product Development Department','name_english' => 'Marketing and Product Development Department']);
        Position::firstOrCreate(['name_khmer' => 'Compliance Department','name_english' => 'Compliance Department']);
        Position::firstOrCreate(['name_khmer' => 'Internal Audit Department','name_english' => 'Internal Audit Department']);
        Position::firstOrCreate(['name_khmer' => 'Risk Management Department','name_english' => 'Risk Management Department']);
    }
}
