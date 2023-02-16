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
        Department::firstOrCreate(['name' => 'Human Resource & Admin Department']);
        Department::firstOrCreate(['name' => 'IT Department']);
        Department::firstOrCreate(['name' => 'Credit Department']);
        Department::firstOrCreate(['name' => 'Marketing & Product Development Department']);
        Department::firstOrCreate(['name' => 'Internal Audit Department']);
        Department::firstOrCreate(['name' => 'Accounting & Finance Department']);
        Department::firstOrCreate(['name' => 'Compliance Department']);
        Department::firstOrCreate(['name' => 'ANS-Angksnuol Branch']);
        Department::firstOrCreate(['name' => 'TKM-Takhmao Branch']);
        Department::firstOrCreate(['name' => 'KPB-Kong Pisei Branch']);
        Department::firstOrCreate(['name' => 'KPS-Kampong speu']);
        Department::firstOrCreate(['name' => 'HO-Operation Unit']);
        Department::firstOrCreate(['name' => 'ITD-HRD']);
        Department::firstOrCreate(['name' => 'MorakotVB Issue']);
        Department::firstOrCreate(['name' => 'Special Loan Approval']);
        Department::firstOrCreate(['name' => 'KTB-kampong Trach']);
        Department::firstOrCreate(['name' => 'SAB- Sa-Ang']);
    }
}
