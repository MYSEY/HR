<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Auth;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=OptionSeeder
     *
     * @return void
     */
    public function run()
    {
        //education
        Option::firstOrCreate([
            'name_khmer' => 'HR Management',
            'name_english'=>'HR Management',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Maketing',
            'name_english'=>'Maketing',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Banking And Financail',
            'name_english'=>'Banking And Financail',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Managerment',
            'name_english'=>'Managerment',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Finance and Accounting',
            'name_english'=>'Finance and Accounting',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Public Law',
            'name_english'=>'Public Law',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Public Administration',
            'name_english'=>'Public Administration',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Information Technology',
            'name_english'=>'Information Technology',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Computer Science',
            'name_english'=>'Computer Science',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Computer Engineering',
            'name_english'=>'Computer Engineering',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Internatoinal Business',
            'name_english'=>'Internatoinal Business',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Business Economic',
            'name_english'=>'Business Economic',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'English Language and Literature',
            'name_english'=>'English Language and Literature',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Hotel &Tourism Managerment',
            'name_english'=>'Hotel &Tourism Managerment',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Internatoinal Relation',
            'name_english'=>'Internatoinal Relation',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'International Business',
            'name_english'=>'International Business',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Secondary School',
            'name_english'=>'Secondary School',
            'type' => 'degree',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'High School',
            'name_english'=>'High School',
            'type' => 'degree',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Associate degree',
            'name_english'=>'Associate degree',
            'type' => 'degree',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => "Bachelor's degree",
            'name_english'=>"Bachelor's degree",
            'type' => 'degree',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => "Master's degree",
            'name_english'=>"Master's degree",
            'type' => 'degree',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => "PHD/Doctoral degree",
            'name_english'=>"PHD/Doctoral degree",
            'type' => 'degree',
            'created_by'    => Auth::id(),
        ]);

        //Gender
        Option::firstOrCreate([
            'name_khmer' => 'Male',
            'name_english'=>'Male',
            'type' => 'gender',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Female',
            'name_english'=>'Female',
            'type' => 'gender',
            'created_by'    => Auth::id(),
        ]);

        // identity type
        Option::firstOrCreate([
            'name_khmer' => 'ID Card',
            'name_english'=>'ID Card',
            'type' => 'identity_type',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Passport',
            'name_english'=>'Passport',
            'type' => 'identity_type',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Family Book',
            'name_english'=>'Family Book',
            'type' => 'identity_type',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Residential',
            'name_english'=>'Residential',
            'type' => 'identity_type',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Other',
            'name_english'=>'Other',
            'type' => 'identity_type',
            'created_by'    => Auth::id(),
        ]);

        // experience
        Option::firstOrCreate([
            'name_khmer' => 'Full-Time',
            'name_english'=>'Full-Time',
            'type' => 'experience',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Path-Time',
            'name_english'=>'Path-Time',
            'type' => 'experience',
            'created_by'    => Auth::id(),
        ]);
        // user
        Option::firstOrCreate([
            'name_khmer' => 'Active',
            'name_english'=>'Active',
            'type' => 'status',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Inactive',
            'name_english'=>'Inactive',
            'type' => 'status',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Disable',
            'name_english'=>'Disable',
            'type' => 'status',
            'created_by'    => Auth::id(),
        ]);
        // Emergency Contact
        Option::firstOrCreate([
            'name_khmer' => 'Father',
            'name_english'=>'Father',
            'type' => 'relationship',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Mother',
            'name_english'=>'Mother',
            'type' => 'relationship',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Husband',
            'name_english'=>'Husband',
            'type' => 'relationship',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Wife',
            'name_english'=>'Wife',
            'type' => 'relationship',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Sister',
            'name_english'=>'Sister',
            'type' => 'relationship',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Brother',
            'name_english'=>'Brother',
            'type' => 'relationship',
            'created_by'    => Auth::id(),
        ]);

        // employee_status
       
            // 'Misconducts',
            // 'Death',
            // 'Retirement',
            // 'Others',
        Option::firstOrCreate([
            'name_khmer' => 'មានការងារធ្វើថ្មី',
            'name_english'=> 'Get New Job',
            'type' => 'emp_status',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ធ្វើអាជីវកម្មផ្ទាល់ខ្លួន',
            'name_english'=> 'Own Business',
            'type' => 'emp_status',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ផ្លាស់ប្តូរទីតាំងរស់នៅ​',
            'name_english'=> 'Relocate Residence',
            'type' => 'emp_status',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'បន្តការសិក្សា',
            'name_english'=> 'Pursuit Study',
            'type' => 'emp_status',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'បញ្ហាសុខភាព',
            'name_english'=> 'Health Issue',
            'type' => 'emp_status',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'គ្រួសារ',
            'name_english'=> 'Personal Issue',
            'type' => 'emp_status',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ការបន្លំលួច/ក្លែបន្លំ',
            'name_english'=> 'Fraud',
            'type' => 'emp_status',
            'created_by'    => Auth::id(),
        ]);
        
        //position type
        Option::firstOrCreate([
            'name_khmer' => 'Supporting Staff',
            'name_english'=> 'Supporting Staff',
            'type' => 'position_type',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Field Staff',
            'name_english'=> 'Field Staff',
            'type' => 'position_type',
            'created_by'    => Auth::id(),
        ]);
        // loan
        Option::firstOrCreate([
            'name_khmer' => 'Yes',
            'name_english'=> 'Yes',
            'type' => 'loan',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'No',
            'name_english'=> 'No',
            'type' => 'loan',
            'created_by'    => Auth::id(),
        ]);
        //spouse
        Option::firstOrCreate([
            'name_khmer' => 'Yes',
            'name_english'=> 'Yes',
            'type' => 'is_spouse',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'No',
            'name_english'=> 'No',
            'type' => 'is_spouse',
            'created_by'    => Auth::id(),
        ]);

    }
}
