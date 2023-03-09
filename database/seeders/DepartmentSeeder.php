<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=DepartmentSeeder
     *
     * @return void
     */
    public function run()
    {
        Department::firstOrCreate(['name_khmer' => 'Board of Director','name_english'=> 'Board of Director']);
        Department::firstOrCreate(['name_khmer' => 'Chief Executive Officer','name_english'=> 'Chief Executive Officer']);
        Department::firstOrCreate(['name_khmer' => 'Human Resources and Admin Department','name_english'=>'Human Resources and Admin Department']);
        Department::firstOrCreate(['name_khmer' => 'Accounting and Finance Department','name_english'=>'Accounting and Finance Department']);
        Department::firstOrCreate(['name_khmer' => 'IT Department','name_english'=>'IT Department']);
        Department::firstOrCreate(['name_khmer' => 'Credit Department','name_english'=>'Credit Department']);
        Department::firstOrCreate(['name_khmer' => 'Marketing and Product Development Department','name_english'=>'Marketing and Product Development Department']);
        Department::firstOrCreate(['name_khmer' => 'Compliance Department','name_english'=>'Compliance Department']);
        Department::firstOrCreate(['name_khmer' => 'Internal Audit Department','name_english'=>'Internal Audit Department']);
        Department::firstOrCreate(['name_khmer' => 'Risk Management Department','name_english'=>'Risk Management Department']);
    }
}
