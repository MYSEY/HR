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
            'name_khmer' => 'ផ្នែកគ្រប់គ្រងធនធានមនុស្ស',
            'name_english'=>'HR Management',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ទីផ្សារ',
            'name_english'=>'Maketing',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ធនាគារ និងហិរញ្ញវត្ថុ',
            'name_english'=>'Banking And Financail',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ផ្នែកគ្រប់គ្រង',
            'name_english'=>'Managerment',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ហិរញ្ញវត្ថុ និងគណនេយ្យ',
            'name_english'=>'Finance and Accounting',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ច្បាប់សាធារណៈ',
            'name_english'=>'Public Law',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'រដ្ឋបាល​សាធារណៈ',
            'name_english'=>'Public Administration',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ព​ត៌​មាន​វិទ្យា',
            'name_english'=>'Information Technology',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'វិទ្យាសាស្ត្រ​កុំព្យូទ័រ',
            'name_english'=>'Computer Science',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'វិស្វករ​កុំព្យូទ័រ',
            'name_english'=>'Computer Engineering',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ជំនួញ​អន្តរជាតិ',
            'name_english'=>'Internatoinal Business',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'សេដ្ឋកិច្ចពាណិជ្ជកម្ម',
            'name_english'=>'Business Economic',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ភាសាអង់គ្លេស និងអក្សរសាស្ត្រ',
            'name_english'=>'English Language and Literature',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ការគ្រប់គ្រងសណ្ឋាគារ និងទេសចរណ៍',
            'name_english'=>'Hotel &Tourism Managerment',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ទំនាក់ទំនងអន្តរជាតិ',
            'name_english'=>'Internatoinal Relation',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ជំនួញ​អន្តរជាតិ',
            'name_english'=>'International Business',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'អនុវិទ្យាល័យ',
            'name_english'=>'Secondary School',
            'type' => 'degree',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'វិទ្យាល័យ',
            'name_english'=>'High School',
            'type' => 'degree',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'បរិញ្ញាបត្ររង',
            'name_english'=>'Associate degree',
            'type' => 'degree',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => "បរិញ្ញាបត្រ",
            'name_english'=>"Bachelor's degree",
            'type' => 'degree',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => "ថ្នាក់អនុបណ្ឌិត",
            'name_english'=>"Master's degree",
            'type' => 'degree',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => "បណ្ឌិត/សញ្ញាបត្របណ្ឌិត",
            'name_english'=>"PHD/Doctoral degree",
            'type' => 'degree',
            'created_by'    => Auth::id(),
        ]);

        //Gender
        Option::firstOrCreate([
            'name_khmer' => 'ប្រុស',
            'name_english'=>'Male',
            'type' => 'gender',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ស្រី',
            'name_english'=>'Female',
            'type' => 'gender',
            'created_by'    => Auth::id(),
        ]);

        // identity type
        Option::firstOrCreate([
            'name_khmer' => 'អត្តសញ្ញាណប័ណ្ណ',
            'name_english'=>'ID Card',
            'type' => 'identity_type',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'លិខិតឆ្លងដែន',
            'name_english'=>'Passport',
            'type' => 'identity_type',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'សៀវភៅគ្រួសារ',
            'name_english'=>'Family Book',
            'type' => 'identity_type',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'លំនៅដ្ឋាន',
            'name_english'=>'Residential',
            'type' => 'identity_type',
            'created_by'    => Auth::id(),
        ]);

        // experience
        Option::firstOrCreate([
            'name_khmer' => 'ពេញ​មោ៉​ង',
            'name_english'=>'Full-Time',
            'type' => 'experience',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'បុគ្គលិកក្រៅម៉ោង',
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
            'name_khmer' => 'ឪពុក',
            'name_english'=>'Father',
            'type' => 'relationship',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ម្តាយ',
            'name_english'=>'Mother',
            'type' => 'relationship',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ប្តី',
            'name_english'=>'Husband',
            'type' => 'relationship',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ប្រពន្ធ',
            'name_english'=>'Wife',
            'type' => 'relationship',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'បងស្រី',
            'name_english'=>'Sister',
            'type' => 'relationship',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'បងប្រុស',
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
        Option::firstOrCreate([
            'name_khmer' => 'បញ្ចប់',
            'name_english'=> 'Termination',
            'type' => 'emp_status',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Death',
            'name_english'=> 'Death',
            'type' => 'emp_status',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'បញ្ឈប់',
            'name_english'=> 'Lay Off',
            'type' => 'emp_status',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'No need to input',
            'name_english'=> 'No need to input',
            'type' => 'emp_status',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'ការសាកល្បងមិនបានជោគជ័យ',
            'name_english'=> 'Failed Probation',
            'type' => 'emp_status',
            'created_by'    => Auth::id(),
        ]);
        
        //position type
        Option::firstOrCreate([
            'name_khmer' => 'បុគ្គលិកគាំទ្រ',
            'name_english'=> 'Supporting Staff',
            'type' => 'position_type',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'បុគ្គលិកចុះតាមតំបន់',
            'name_english'=> 'Field Staff',
            'type' => 'position_type',
            'created_by'    => Auth::id(),
        ]);
    }
}
