<?php

namespace Database\Seeders;

use App\Models\ChildrenAllowance;
use Illuminate\Database\Seeder;

class ChildrenAllowanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=ChildrenAllowanceSeeder
     *
     * @return void
     */
    public function run()
    {
        ChildrenAllowance::firstOrCreate(['total_children_allowance' => '10','reduced_burden_children' => '150000','spouse_allowance'=>'150000']);
    }
}
