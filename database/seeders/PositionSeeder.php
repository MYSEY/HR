<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=PositionSeeder
     *
     * @return void
     */
    public function run()
    {
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានក្រុមប្រឹក្សាភិបាល',
            'name_english'      => 'Board of Director',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Director'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អគ្គនាយកប្រតិបត្តិ',
            'name_english'      => 'Chief Executive Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'General Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អគ្គនាយកប្រតិបត្តិស្តីទី',
            'name_english'      => 'Acting Chief Executive Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'General Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អគ្គនាយករងប្រតិបត្តិ',
            'name_english'      => 'Deputy Chief Executive Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'General Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយក នាយកដ្ឋានធនធានមនុស្ស និងរដ្ឋបាល',
            'name_english'      => 'Head of HR and Admin Department',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយករង នាយកដ្ឋានធនធានមនុស្ស និងរដ្ឋបាល',
            'name_english'      => 'Deputy Head of HR and Admin Department',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Deputy Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានជាន់ខ្ពស់ផ្នែកសំណង និងជ្រើសរើសបុគ្គលិក',
            'name_english'      => 'Senior Manager, Personnel and Recruitment ',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកវាយតម្លៃការអនុវត្តការងារ',
            'name_english'      => 'Performance Appraisals Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកជ្រើសរើសបុគ្គលិក',
            'name_english'      => 'Recruitment Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកទូទាត់សំណង និងអត្ថប្រយោជន៍',
            'name_english'      => 'Compensation and Benefits Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែកធនធានមនុស្ស',
            'name_english'      => 'Deputy HR Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែកជ្រើសរើសបុគ្គលិក',
            'name_english'      => 'Deputy Recruitment Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែកទូទាត់សំណង និងអត្ថប្រយោជន៍',
            'name_english'      => 'Deputy Compensation and Benefits Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែកវាយតម្លៃការអនុវត្តការងារ',
            'name_english'      => 'Deputy Performance Appraisals Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកផ្នែកជ្រើសរើសបុគ្គលិកជាន់ខ្ពស់',
            'name_english'      => 'Senior Recruitment Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកទូទាត់សំណង និងអត្ថប្រយោជន៍ជាន់ខ្ពស់',
            'name_english'      => 'Senior Compensation and Benefits Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកវាយតម្លៃការអនុវត្តការងារជាន់ខ្ពស់',
            'name_english'      => 'Senior Performance Appraisals Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកធនធានមនុស្សជាន់ខ្ពស់',
            'name_english'      => 'Senior Human Resources Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកវាយតម្លៃការអនុវត្តការងារ',
            'name_english'      => 'Performance Appraisals Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកទូទាត់សំណង និងអត្ថប្រយោជន៍',
            'name_english'      => 'Compensation and Benefits Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកធនធានមនុស្ស',
            'name_english'      => 'Human Resources Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ជំនួយការធនធានមនុស្ស',
            'name_english'      => 'Human Resources Assistant',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Assistant'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានជាន់ខ្ពស់ផ្នែកបណ្តុះបណ្តាល និងអភិវឌ្ឍន៍',
            'name_english'      => 'Senior Manager, Training & Development',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកបណ្តុះបណ្តាល និងអភិវឌ្ឍន៍',
            'name_english'      => 'Training & Development Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែកបណ្តុះបណ្តាល និងអភិវឌ្ឍន៍',
            'name_english'      => 'Deputy Training & Development Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកផ្នែកបណ្តុះបណ្តាល និងអភិវឌ្ឍន៍ជាន់ខ្ពស់',
            'name_english'      => 'Senior Training and Development Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកផ្នែកបណ្តុះបណ្តាល និងអភិវឌ្ឍន៍',
            'name_english'      => 'Training and Development Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ជំនួយការផ្នែកបណ្តុះបណ្តាល និងអភិវឌ្ឍន៍',
            'name_english'      => 'Training and Development Assistant',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានជាន់ខ្ពស់ផ្នែករដ្ឋបាល',
            'name_english'      => 'Senior Manager of Administrative',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែករដ្ឋបាល',
            'name_english'      => 'Administrative Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែករដ្ឋបាល',
            'name_english'      => 'Deputy Administrative Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិករដ្ឋបាលជាន់ខ្ពស់',
            'name_english'      => 'Senior Administrative Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកគ្រប់គ្រងទ្រព្យសកម្ម និងសារពើភ័ណ្ឌជាន់ខ្ពស់',
            'name_english'      => 'Senior Fixed Assets & Inventory Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកគ្រប់គ្រងការិយាល័យជាន់ខ្ពស់',
            'name_english'      => 'Senior Office Management Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកផ្នែកលទ្ធកម្មជាន់ខ្ពស់',
            'name_english'      => 'Senior Procurement Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកគ្រប់គ្រងការិយាល័យ',
            'name_english'      => 'Office Management Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកគ្រប់គ្រងទ្រព្យសកម្ម និងសារពើភ័ណ្ឌ',
            'name_english'      => 'Fixed Assets & Inventory Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកផ្នែកលទ្ធកម្ម',
            'name_english'      => 'Procurement Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិករដ្ឋបាល',
            'name_english'      => 'Administrative Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ជំនួយការបុគ្គលិករដ្ឋបាល',
            'name_english'      => 'Administrative Assistant',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Assistant'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកសន្តិសុខ​',
            'name_english'      => 'Security Guard',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Others'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អ្នកបើកបរ',
            'name_english'      => 'Driver',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Others'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អ្នកថែទាំការិយាល័យ',
            'name_english'      => 'Cleaner',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Others'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយិកា នាយកដ្ឋានគណនេយ្យ និងហិរញ្ញវត្ថុ',
            'name_english'      => 'Head of Accounting and Finance Department',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយិការង នាយកដ្ឋានគណនេយ្យ និងហិរញ្ញវត្ថុផ្នែកហេរញ្ញិក',
            'name_english'      => 'Deputy Head of Accounting and Finance Department Treasury Unit',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Deputy Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានជាន់ខ្ពស់ផ្នែកគណនេយ្យ និងហិរញ្ញវត្ថុ',
            'name_english'      => 'Senior Manager of Accounting and Finance',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែករបាយការណ៍',
            'name_english'      => 'Reporting Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកពន្ធ',
            'name_english'      => 'Tax Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកគាំទ្រគណនេយ្យ និងហិរញ្ញវត្ថុ',
            'name_english'      => 'Accounting and Finance Supporting Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកគណនេយ្យហិរញ្ញវត្ថុ',
            'name_english'      => 'Financial Accounting Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែកគណនេយ្យហិរញ្ញវត្ថុ',
            'name_english'      => 'Deputy Financial Accounting Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកគណនេយ្យហិរញ្ញវត្ថុជាន់ខ្ពស់',
            'name_english'      => 'Senior Financial Accounting Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកគាំទ្រគណនេយ្យ និងហិរញ្ញវត្ថុជាន់ខ្ពស់',
            'name_english'      => 'Senior Accounting and Finance Supporting Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកឯកទេសគណនេយ្យហិរញ្ញវត្ថុ',
            'name_english'      => 'Financial Accounting Specialist',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកគណនេយ្យហិរញ្ញវត្ថុ',
            'name_english'      => 'Financial Accounting Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ជំនួយការបុគ្គលិកគណនេយ្យហិរញ្ញវត្ថុ',
            'name_english'      => 'Financial Accounting Assistant',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកហេរញ្ញិក',
            'name_english'      => 'Treasury Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'         => 'អនុប្រធានផ្នែកហេរញ្ញិក',
            'name_english'      => 'Deputy Treasury Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកហេរញ្ញិកជាន់ខ្ពស់',
            'name_english'      => 'Senior Treasury Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកហេរញ្ញិក',
            'name_english'      => 'Treasury Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ជំនួយការបុគ្គលិកហេរញ្ញិក',
            'name_english'      => 'Treasury Assistant',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Assistant'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយក នាយកដ្ឋានបច្ចេកវិទ្យាព័ត៌មាន',
            'name_english'      => 'Head of Information Technology Department',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយក នាយករង នាយកដ្ឋានបច្ចេកវិទ្យាព័ត៌មាន',
            'name_english'      => 'Deputy Head of Information Technology Department',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Deputy Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកបច្ចេកវិទ្យាព័ត៌មាន',
            'name_english'      => 'Information Technology Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកហេដ្ឋារចនាសម្ព័ន្ធបណ្តាញព័ត៌មានវិទ្យា',
            'name_english'      => 'System Infrastructure Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកគាំទ្របច្ចេកវិទ្យាព័ត៌មាន',
            'name_english'      => 'End User Support Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកអភិវឌ្ឍប្រព័ន្ធបច្ចេកវិទ្យាព័ត៌មាន',
            'name_english'      => 'Software & App Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែកបច្ចេកវិទ្យាព័ត៌មាន',
            'name_english'      => 'Deputy Information Technology Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែកហេដ្ឋារចនាសម្ព័ន្ធបណ្តាញព័ត៌មានវិទ្យា',
            'name_english'      => 'Deputy System Infrastructure Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែកគាំទ្របច្ចេកវិទ្យាព័ត៌មាន',
            'name_english'      => 'Deputy End User Support Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែកអភិវឌ្ឍប្រព័ន្ធបច្ចេកវិទ្យាព័ត៌មាន',
            'name_english'      => 'Deputy Software & App Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកហេដ្ឋារចនាសម្ព័ន្ធបណ្តាញព័ត៌មានវិទ្យាជាន់ខ្ពស់',
            'name_english'      => 'Senior Infrastructure Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកគាំទ្របច្ចេកវិទ្យាព័ត៌មានជាន់ខ្ពស់',
            'name_english'      => 'Senior End User Support Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកអភិវឌ្ឍប្រព័ន្ធបច្ចេកវិទ្យាព័ត៌មានជាន់ខ្ពស់',
            'name_english'      => 'Senior Software & App Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកបច្ចេកវិទ្យាព័ត៌មានជាន់ខ្ពស់',
            'name_english'      => 'Senior Information Technology Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកគាំទ្របច្ចេកវិទ្យាព័ត៌មាន',
            'name_english'      => 'End User Support Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកគាំទ្រព័ន្ធCBC',
            'name_english'      => 'CBC Support Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកហេដ្ឋារចនាសម្ព័ន្ធបណ្តាញព័ត៌មានវិទ្យា',
            'name_english'      => 'Infrastructure Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកអភិវឌ្ឍប្រព័ន្ធបច្ចេកវិទ្យាព័ត៌មាន',
            'name_english'      => 'Software  & App Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកបច្ចេកវិទ្យាព័ត៌មាន',
            'name_english'      => 'Information Technology Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ជំនួយការបុគ្គលិកបច្ចេកវិទ្យាព័ត៌មាន',
            'name_english'      => 'Information Technology Assistant',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយក នាយកដ្ឋានសវនកម្មផ្ទៃក្នុង',
            'name_english'      => 'Head of Internal Audit Department',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយករង នាយកដ្ឋានសវនកម្មផ្ទៃក្នុង',
            'name_english'      => 'Deputy Head of Internal Audit Department',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Deputy Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកសវនករផ្ទៃក្នុង',
            'name_english'      => 'Internal Audit Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែកសវនករផ្ទៃក្នុង',
            'name_english'      => 'Deputy Internal Audit Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'សវនករផ្ទៃក្នុងជាន់ខ្ពស់',
            'name_english'      => 'Senior Internal Audit Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'សវនករផ្ទៃក្នុង',
            'name_english'      => 'Internal Audit Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយ នាយកដ្ឋានឥណទាន',
            'name_english'      => 'Head of Credit Department',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយករង នាយកដ្ឋានឥណទាន',
            'name_english'      => 'Deputy Head of Credit Department',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Deputy Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកលក់ឥណទានឌីជីថល',
            'name_english'      => 'Digital Lending Unit Manager',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកវាយតម្លៃឥណទានឌីជីថល',
            'name_english'      => 'Digital Assessment Unit Manager',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកលក់សាជីវកម្ម',
            'name_english'      => 'Corporate Sales Unit Manager',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកឥណទានយានយន្ត',
            'name_english'      => 'Auto Loan Unit Manager',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកផលប័ត្រឥណទាន',
            'name_english'      => 'Credit Portfolio Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកត្រួតពិនិត្យឥណទាន',
            'name_english'      => 'Credit Control Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកវិភាគឥណទាន',
            'name_english'      => 'Credit Underwriting Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកលក់ឥណទានខ្នាតតូច និងមធ្យម',
            'name_english'      => 'SME Lending Unit Manager',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកដោះស្រាយឥណទានយឺតយ៉ាវ',
            'name_english'      => 'Loan Recovery Unit Manager',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានគ្រប់គ្រងសាខា',
            'name_english'      => 'Branch Supervision Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកលក់ឥណទានឌីជីថលជាន់ខ្ពស់',
            'name_english'      => 'Senior Digital Lending Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកផ្នែកវាយតម្លៃឥណទានឌីជីថលជាន់ខ្ពស់',
            'name_english'      => 'Senior Digital Loan Assessment Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកលក់សាជីវកម្មជាន់ខ្ពស់',
            'name_english'      => 'Senior Corporate Sales Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកឥណទានយានយន្តជាន់ខ្ពស់',
            'name_english'      => 'Senior Auto Loan Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'មន្ត្រីការវាយតម្លៃជាន់ខ្ពស់',
            'name_english'      => 'Senior Assessment Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកផលប័ត្រឥណទានជាន់ខ្ពស់',
            'name_english'      => 'Senior Credit Portfolio Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកត្រួតពិនិត្យឥណទានជាន់ខ្ពស់',
            'name_english'      => 'Senior Credit Control Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកវិភាគឥណទានជាន់ខ្ពស់',
            'name_english'      => 'Senior Credit Underwriting Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកផ្នែកលក់ឥណទានខ្នាតតូច និងមធ្យមជាន់ខ្ពស់',
            'name_english'      => 'Senior SME Lending Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកដោះស្រាយឥណទានជាន់ខ្ពស់',
            'name_english'      => 'Senior Loan Recovery Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកផ្នែកលក់ឥណទានឌីជីថល',
            'name_english'      => 'Digital Lending Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកលក់សាជីវកម្ម',
            'name_english'      => 'Corporate Sales Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកឥណទានយានយន្ត',
            'name_english'      => 'Auto Loan Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិករដ្ឋបាលឥណទាន',
            'name_english'      => 'Credit Admin Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកត្រួតពិនិត្យឥណទាន',
            'name_english'      => 'Credit Control Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកវិភាគឥណទាន',
            'name_english'      => 'Credit Underwriting Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកផ្នែកលក់ឥណទានខ្នាតតូច និងមធ្យម',
            'name_english'      => 'SME Lending Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកដោះស្រាយឥណទាន',
            'name_english'      => 'Loan Recovery Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកឥណទានយានយន្តថ្មី',
            'name_english'      => 'Junior Auto Loan Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយក នាយកដ្ឋានទីផ្សារ និងអភិវឌ្ឍន៍ផលិតផល',
            'name_english'      => 'Head of Marketing and Product Development Department',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយករង នាយកដ្ឋានទីផ្សារ និងអភិវឌ្ឍន៍ផលិតផល',
            'name_english'      => 'Depuy Head of Marketing and Product Development Department',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Deputy Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានជាន់ខ្ពស់ផ្នែកអភិវឌ្ឍន៍ផលិតផល',
            'name_english'      => 'Senior Manager, Product Development',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកអភិវឌ្ឍន៍ផលិតផល',
            'name_english'      => 'Product Development Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែកទីផ្សារឌីជីថល',
            'name_english'      => 'Digital Marketing Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានផ្នែករចនាក្រហ្វិក',
            'name_english'      => 'Creative Design Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែកអភិវឌ្ឍន៍ផលិតផល',
            'name_english'      => 'Deputy Product Development Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែកទីផ្សារឌីជីថល',
            'name_english'      => 'Deputy Digital Marketing Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'អនុប្រធានផ្នែករចនាក្រាហ្វិក',
            'name_english'      => 'Deputy Creative Design Unit Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកស្រាវជ្រាវផ្នែកទីផ្សារជាន់ខ្ពស់',
            'name_english'      => 'Senior Marketing Research Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកអភិវឌ្ឍន៍ផលិតផលជាន់ខ្ពស់',
            'name_english'      => 'Senior Product Development Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកឯកទេសទីផ្សារឌីជីថល',
            'name_english'      => 'Digital Marketing Specialist',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិករចនាក្រហ្វិកជាន់ខ្ពស់',
            'name_english'      => 'Senior Creative Designer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកអភិវឌ្ឍន៍គោលនយោបាយឥណទានជាន់ខ្ពស់',
            'name_english'      => 'Senior Policy Development Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកបម្រើសេវា និងទំនាក់ទំនងអតិថជនជាន់ខ្ពស់',
            'name_english'      => 'Senior Customer Service Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកអភិវឌ្ឍន៍ផលិតផល',
            'name_english'      => 'Product Development Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកបម្រើសេវា និងទំនាក់ទំនងអតិថជន',
            'name_english'      => 'Customer Service Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិករចនាក្រាហ្វិក',
            'name_english'      => 'Creative Designer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកអភិវឌ្ឍន៍គោលនយោបាយឥណទាន',
            'name_english'      => 'Policy Development Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយក នាយកដ្ឋានប្រតិបត្តិតាម',
            'name_english'      => 'Head of Compliance Department',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយករង នាយកដ្ឋានប្រតិបត្តិតាម',
            'name_english'      => 'Deputy Head of Compliance Department',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Deputy Manager'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានមុខងារប្រតិបត្តិតាម',
            'name_english'      => 'Compliance Manager',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'មន្រ្តីប្រតិបត្តិតាម',
            'name_english'      => 'Compliance Officer',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយក​ ការិយាល័យប្រតិបត្តិការ',
            'name_english'      => 'Operation Manager',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយក​ សាខា',
            'name_english'      => 'Branch Manager',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយករង ការិយាល័យប្រតិបត្តិការ',
            'name_english'      => 'Deputy Operation Manager',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'នាយក​រង សាខា',
            'name_english'      => 'Deputy Branch Manager',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានភ្នាក់ងារឥណទាន',
            'name_english'      => 'Chief Credit Officer',
            'type'              => 'Credit_Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានគណនេយ្យករប្រតិបត្តិការ',
            'name_english'      => 'Chief Operation Accountant',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានគណនេយ្យករសាខា',
            'name_english'      => 'Chief Branch Accountant',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានបេឡាករ',
            'name_english'      => 'Chief Teller',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ប្រធានក្រុមបេឡករ',
            'name_english'      => 'Teller Team Leader',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Supervisor'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ភ្នាក់ងារឥណទានជាន់ខ្ពស់',
            'name_english'      => 'Senior Credit Officer',
            'type'              => 'Credit_Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'គណនេយ្យករប្រតិបត្តិការជាន់ខ្ពស់',
            'name_english'      => 'Senior Operation Accountant',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'គណនេយ្យករសាខាជាន់ខ្ពស់',
            'name_english'      => 'Senior Branch Accountant',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ភ្នាក់ងារឥណទាន',
            'name_english'      => 'Credit Officer',
            'type'              => 'Credit_Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'ភ្នាក់ងារឥណទានថ្មី',
            'name_english'      => 'Junior Credit Officer',
            'position_type'     => 'Field Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'គណនេយ្យករប្រតិបត្តិការ',
            'name_english'      => 'Operation Accountant',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'គណនេយ្យករសាខា',
            'name_english'      => 'Branch Accountant',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បេឡាករជាន់ខ្ពស់',
            'name_english'      => 'Senior Teller',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បេឡាករ​',
            'name_english'      => 'Teller',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Officer'
        ]);
        Position::firstOrCreate([
            'name_khmer'        => 'បុគ្គលិកហាត់ការ',
            'name_english'      => 'Internship',
            'position_type'     => 'Supporting Staff',
            'position_range'    => 'Others'
        ]);
    }
}
