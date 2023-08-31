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
        Department::firstOrCreate(['name_khmer' => 'ក្រុមប្រឹក្សាភិបាល','name_english'=> 'Board of Director']);
        Department::firstOrCreate(['name_khmer' => 'នាយក​ប្រតិបត្តិ','name_english'=> 'Chief Executive Officer']);
        Department::firstOrCreate(['name_khmer' => 'នាយកដ្ឋានធនធានមនុស្ស និងរដ្ឋបាល','name_english'=>'Human Resources and Admin Department']);
        Department::firstOrCreate(['name_khmer' => 'នាយកដ្ឋានគណនេយ្យ និងហិរញ្ញវត្ថុ','name_english'=>'Accounting and Finance Department']);
        Department::firstOrCreate(['name_khmer' => 'នាយកដ្ឋានព័ត៌មានវិទ្យា','name_english'=>'IT Department']);
        Department::firstOrCreate(['name_khmer' => 'នាយកដ្ឋានឥណទាន','name_english'=>'Credit Department']);
        Department::firstOrCreate(['name_khmer' => 'នាយកដ្ឋានទីផ្សារ និងអភិវឌ្ឍន៍ផលិតផល','name_english'=>'Marketing and Product Development Department']);
        Department::firstOrCreate(['name_khmer' => 'នាយកដ្ឋានអនុលោមភាព','name_english'=>'Compliance Department']);
        Department::firstOrCreate(['name_khmer' => 'នាយកដ្ឋានសវនកម្មផ្ទៃក្នុង','name_english'=>'Internal Audit Department']);
        Department::firstOrCreate(['name_khmer' => 'នាយកដ្ឋានគ្រប់គ្រងហានិភ័យ','name_english'=>'Risk Management Department']);
    }
}
