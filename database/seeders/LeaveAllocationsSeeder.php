<?php

namespace Database\Seeders;

use App\Models\LeaveAllocation;
use Illuminate\Database\Seeder;

class LeaveAllocationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=LeaveAllocationsSeeder
     *
     * @return void
     */
    public function run()
    {
        LeaveAllocation::updateOrCreate([
            'employee_id' => '1',
            'default_annual_leave' => '0',
            'default_sick_leave' => '0',
            'default_special_leave' => '0',
            'default_unpaid_leave' => '0',
            'total_annual_leave' => '0',
            'total_sick_leave' => '0',
            'total_special_leave' => '0',
            'total_unpaid_leave' => '0',
            'year_1' => '0',
            'year_2' => '0',
            'year_3' => '0',
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        LeaveAllocation::updateOrCreate([
            'employee_id' => '2',
            'default_annual_leave' => '0',
            'default_sick_leave' => '0',
            'default_special_leave' => '0',
            'default_unpaid_leave' => '0',
            'total_annual_leave' => '0',
            'total_sick_leave' => '0',
            'total_special_leave' => '0',
            'total_unpaid_leave' => '0',
            'year_1' => '0',
            'year_2' => '0',
            'year_3' => '0',
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}
