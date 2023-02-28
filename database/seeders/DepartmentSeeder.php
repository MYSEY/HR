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
        Department::firstOrCreate(['name' => 'Board of Director']);
        Department::firstOrCreate(['name' => 'Chief Executive Officer']);
        Department::firstOrCreate(['name' => 'Human Resources and Admin Department']);
        Department::firstOrCreate(['name' => 'Accounting and Finance Department']);
        Department::firstOrCreate(['name' => 'IT Department']);
        Department::firstOrCreate(['name' => 'Credit Department']);
        Department::firstOrCreate(['name' => 'Marketing and Product Development Department']);
        Department::firstOrCreate(['name' => 'Compliance Department']);
        Department::firstOrCreate(['name' => 'Internal Audit Department']);
        Department::firstOrCreate(['name' => 'Risk Management Department']);
    }
}
