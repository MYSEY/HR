<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=LeaveTypeSeeder
     *
     * @return void
     */
    public function run()
    {
        LeaveType::updateOrCreate([
            'name' => 'Annual Leave',
            'default_day' => '18',
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        LeaveType::updateOrCreate([
            'name' => 'Sick Leave',
            'default_day' => '10',
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        LeaveType::updateOrCreate([
            'name' => 'Special Leave',
            'default_day' => '22',
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}
