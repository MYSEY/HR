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
        $datas = [
            [
                'parent_id'=> '',
                'name_khmer' => 'ក្រុមប្រឹក្សាភិបាល',
                'name_english'=> 'Board of Director'
            ],
            [
                'parent_id'=> '',
                'name_khmer' => 'នាយក​ប្រតិបត្តិ',
                'name_english'=> 'Chief Executive Officer'
            ],
            [
                'parent_id'=> '',
                'name_khmer' => 'នាយកដ្ឋានធនធានមនុស្ស និងរដ្ឋបាល',
                'name_english'=>'Human Resources and Admin Department'
            ],
            [
                'parent_id'=> '',
                'name_khmer' => 'នាយកដ្ឋានគណនេយ្យ និងហិរញ្ញវត្ថុ',
                'name_english'=>'Accounting and Finance Department'
            ],
            [
                'parent_id'=> '',
                'name_khmer' => 'នាយកដ្ឋានព័ត៌មានវិទ្យា',
                'name_english'=>'IT Department'
            ],
            [
                'parent_id'=> '',
                'name_khmer' => 'នាយកដ្ឋានឥណទាន',
                'name_english'=>'Credit Department'
            ],
            [
                'parent_id'=> '',
                'name_khmer' => 'នាយកដ្ឋានទីផ្សារ និងអភិវឌ្ឍន៍ផលិតផល',
                'name_english'=>'Marketing and Product Development Department'
            ],
            [
                'parent_id'=> '',
                'name_khmer' => 'នាយកដ្ឋានអនុលោមភាព',
                'name_english'=>'Compliance Department'
            ],
            [
                'parent_id'=> '',
                'name_khmer' => 'នាយកដ្ឋានសវនកម្មផ្ទៃក្នុង',
                'name_english'=>'Internal Audit Department'
            ],
            [
                'parent_id'=> '',
                'name_khmer' => 'នាយកដ្ឋានគ្រប់គ្រងហានិភ័យ',
                'name_english'=>'Risk Management Department'
            ],
            [
                'parent_id'=> '',
                'name_khmer' => 'នាយកដ្ឋានឥណទាន',
                'name_english'=>'Credit Department Digital'
            ],
        ];
        $parent_id = null;
        foreach ($datas as $key => $item) {
            if ($item["name_english"] == "Credit Department") {
                $parent_id = $key+1;
            }
            if ($item["name_english"] == "Credit Department Digital") {
                $item["parent_id"] = $parent_id;
            }
            Department::firstOrCreate($item);
        }
    }
}
