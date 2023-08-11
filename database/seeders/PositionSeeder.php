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
        Position::firstOrCreate(['name_khmer' => 'អគ្គនាយិកាប្រតិបត្តិ','name_english' => 'Chief Executive Officer']);
        Position::firstOrCreate(['name_khmer' => 'អគ្គនាយករងប្រតិបត្តិ','name_english' => 'Deputy Chief Executive Officer']);
        Position::firstOrCreate(['name_khmer' => 'អគ្គនាយកប្រតិបត្តិ','name_english' => 'Chief Executive Officer']);
        Position::firstOrCreate(['name_khmer' => 'នាយក នាយកដ្ឋានធនធានមនុស្ស និងរដ្ឋបាល','name_english' => 'Head of HR and Admin Department']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានជាន់ខ្ពស់ផ្នែកបុគ្គលិក និងជ្រើសរើសបុគ្គលិក','name_english' => 'Senior personnel and Recuitment Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកជ្រើសរើសបុគ្គលិក','name_english' => 'Recuitment Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'អនុប្រធានផ្នែកធនធានមនុស្ស','name_english' => 'Deputy HR Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'អនុប្រធានផ្នែកជ្រើសរើសបុគ្គលិក','name_english' => 'Deputy Recruitment Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'អនុប្រធានផ្នែកទូទាត់សំណង និងអត្ថប្រយោជន៍','name_english' => 'Deputy Compensation and Benefits Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'អនុប្រធានផ្នែកវាយតម្លៃការអនុវត្តការងារ','name_english' => 'Deputy Performance Appraisals Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកផ្នែកជ្រើសរើសបុគ្គលិកជាន់ខ្ពស់','name_english' => 'Senior Recriutment Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកទូទាត់សំណង និងអត្ថប្រយោជន៍ជាន់ខ្ពស់','name_english' => 'Senior Compensation and Benefits Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកវាយតម្លៃការអនុវត្តការងារជាន់ខ្ពស់','name_english' => 'Senior Performance Appraisals Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកធនធានមនុស្សជាន់ខ្ពស់','name_english' => 'Senior Human Resources Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកវាយតម្លៃការអនុវត្តការងារ','name_english' => 'Performance Appraisals Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកទូទាត់សំណង និងអត្ថប្រយោជន៍','name_english' => 'Ompensation and Benefits Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកធនធានមនុស្ស','name_english' => 'Human Resources Officer']);
        Position::firstOrCreate(['name_khmer' => 'ជំនួយការធនធានមនុស្ស','name_english' => 'Human ResourcesAssistant']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានជាន់ខ្ពស់ផ្នែកបណ្តុះបណ្តាលនិងអភិវឌ្ឍន៍','name_english' => 'Senior Manager of Training & Development']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកបណ្តុះបណ្តាលនិងអភិវឌ្ឍន៍','name_english' => 'Training & Development Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'អនុប្រធានផ្នែកបណ្តុះបណ្តាលនិងអភិវឌ្ឍន៍','name_english' => 'Deputy Training & Development Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកផ្នែកបណ្តុះបណ្តាលនិងអភិវឌ្ឍន៍ជាន់ខ្ពស់','name_english' => 'Senior Training and Development Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកផ្នែកបណ្តុះបណ្តាលនិងអភិវឌ្ឍន៍','name_english' => 'Training and Development Officer']);
        Position::firstOrCreate(['name_khmer' => 'ជំនួយការផ្នែកបណ្តុះបណ្តាលនិងអភិវឌ្ឍន៍','name_english' => 'Training and Development Assistant']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានជាន់ខ្ពស់ផ្នែករដ្ឋបាល ','name_english' => 'Senior Manager of Administrative']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែករដ្ឋបាល','name_english' => 'Administrative Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'អនុប្រធានផ្នែករដ្ឋបាល','name_english' => 'Deputy Administrative Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិករដ្ឋបាលជាន់ខ្ពស់','name_english' => 'Senior Administrative Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកគ្រប់គ្រងទ្រព្យសកម្ម និងសារពើភ័ណ្ឌជាន់ខ្ពស់','name_english' => 'Senior Fixed Assets & Inventory Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកគ្រប់គ្រងការិយាល័យជាន់ខ្ពស់','name_english' => 'Senior Office Management Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកផ្នែកលទ្ធកម្មជាន់ខ្ពស់','name_english' => 'Senior Procurement Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកគ្រប់គ្រងការិយាល័យ','name_english' => 'Office Management Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកគ្រប់គ្រងទ្រព្យសកម្ម និងសារពើភ័ណ្ឌ','name_english' => 'Fixed Assets & Inventory Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកផ្នែកលទ្ធកម្ម','name_english' => 'Procurement Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិករដ្ឋបាល','name_english' => 'Administrative Officer']);
        Position::firstOrCreate(['name_khmer' => 'ជំនួយការបុគ្គលិករដ្ឋបាល','name_english' => 'Administrative Assistant']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកសន្តិសុខ​','name_english' => 'Security Guard']);
        Position::firstOrCreate(['name_khmer' => 'អ្នកបើកបរ','name_english' => 'Driver']);
        Position::firstOrCreate(['name_khmer' => 'អ្នកថែទាំការិយាល័យ','name_english' => 'Cleaner']);
        Position::firstOrCreate(['name_khmer' => 'នាយិកា នាយកដ្ឋានគណនេយ្យ និងហិរញ្ញវត្ថុ','name_english' => 'Head of Accounting and Finance Department']);
        Position::firstOrCreate(['name_khmer' => 'នាយករង នាយកដ្ឋានគណនេយ្យ និងហិរញ្ញវត្ថុ','name_english' => 'Deputy of Accounting and Finance Department']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានជាន់ខ្ពស់ផ្នែកគណនេយ្យ និងហិរញ្ញវត្ថុ','name_english' => 'Senior Manager of Accounting and Finance']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែករបាយការណ៍','name_english' => 'Reporting Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកពន្ធ','name_english' => 'Tax Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកគាំទ្រគណនេយ្យ និងហិរញ្ញវត្ថុ','name_english' => 'Accounting and Finance Supporting Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកគណនេយ្យហិរញ្ញវត្ថុ','name_english' => 'Financial Accounting Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'អនុប្រធានផ្នែកគណនេយ្យហិរញ្ញវត្ថុ','name_english' => 'Deputy Financial Accounting Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកគណនេយ្យហិរញ្ញវត្ថុជាន់ខ្ពស់','name_english' => 'Senior Financial Accounting Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកគាំទ្រគណនេយ្យ និងហិរញ្ញវត្ថុជាន់ខ្ពស់','name_english' => 'Senior Accounting and Finance Supporting Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកឯកទេសគណនេយ្យហិរញ្ញវត្ថុ','name_english' => 'Financial Accounting Specailist']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកគណនេយ្យហិរញ្ញវត្ថុ','name_english' => 'Financial Accounting Officer']);
        Position::firstOrCreate(['name_khmer' => 'នាយិការង នាយកដ្ឋានគណនេយ្យ និងហិរញ្ញវត្ថុផ្នែកហេរញ្ញិក','name_english' => 'Deputy Head of Accounting and Finance Department Treasury Unit']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកហេរញ្ញិក','name_english' => 'Treasury Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'អនុប្រធានផ្នែកហេរញ្ញិក','name_english' => 'Deputy Treasury Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកហេរញ្ញិកជាន់ខ្ពស់','name_english' => 'Senior Treasury Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកហេរញ្ញិក','name_english' => 'Treasury Officer']);
        Position::firstOrCreate(['name_khmer' => 'ជំនួយការបុគ្គលិកហេរញ្ញិក','name_english' => 'Treasury Assistant']);
        Position::firstOrCreate(['name_khmer' => 'នាយក នាយកដ្ឋានបច្ចេកវិទ្យាព័ត៌មាន','name_english' => 'Head of Information Technology Department']);
        Position::firstOrCreate(['name_khmer' => 'នាយក នាយករង នាយកដ្ឋានបច្ចេកវិទ្យាព័ត៌មាន','name_english' => 'Deputy Head of Information Technology Department']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកបច្ចេកវិទ្យាព័ត៌មាន','name_english' => 'Information Technology Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកហេដ្ឋារចនាសម្ព័ន្ធបណ្តាញព័ត៌មានវិទ្យា','name_english' => 'System Infrastructure Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកគាំទ្របច្ចេកវិទ្យាព័ត៌មាន','name_english' => 'End User Support Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកហេដ្ឋារចនាសម្ព័ន្ធបណ្តាញព័ត៌មានវិទ្យាជាន់ខ្ពស់','name_english' => 'Senior Infrastructure Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកគាំទ្របច្ចេកវិទ្យាព័ត៌មានជាន់ខ្ពស់','name_english' => 'Senior End User Support Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកអភិវឌ្ឍប្រព័ន្ធបច្ចេកវិទ្យាព័ត៌មានជាន់ខ្ពស់','name_english' => 'Senior Soft & App Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកបច្ចេកវិទ្យាព័ត៌មានជាន់ខ្ពស់','name_english' => 'Senior Information Technology Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកគាំទ្របច្ចេកវិទ្យាព័ត៌មាន','name_english' => 'End User Support Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកគាំទ្រព័ន្ធCBC','name_english' => 'CBC Supporter']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកហេដ្ឋារចនាសម្ព័ន្ធបណ្តាញព័ត៌មានវិទ្យា','name_english' => 'Infrastructure Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកអភិវឌ្ឍប្រព័ន្ធបច្ចេកវិទ្យាព័ត៌មាន','name_english' => 'Soft & App Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកបច្ចេកវិទ្យាព័ត៌មាន','name_english' => 'InformationTechnology Officer']);
        Position::firstOrCreate(['name_khmer' => 'ជំនួយការបុគ្គលិកបច្ចេកវិទ្យាព័ត៌មាន','name_english' => 'InformationTechnology Assistant']);
        Position::firstOrCreate(['name_khmer' => 'នាយក នាយកដ្ឋានសវនកម្មផ្ទៃក្នុង','name_english' => 'Head of Internal Audit Department']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកសវនករផ្ទៃក្នុង','name_english' => 'Internal Audit Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'អនុប្រធានផ្នែកសវនករផ្ទៃក្នុង','name_english' => 'Deputy Internal Audit Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'សវនករផ្ទៃក្នុងជាន់ខ្ពស់','name_english' => 'Senior Internal Audit Officer']);
        Position::firstOrCreate(['name_khmer' => 'សវនករផ្ទៃក្នុង','name_english' => 'Internal Audit Officer']);
        Position::firstOrCreate(['name_khmer' => 'នាយ នាយកដ្ឋានឥណទាន','name_english' => 'Head of Credit Department']);
        Position::firstOrCreate(['name_khmer' => 'នាយរង នាយកដ្ឋានឥណទាន','name_english' => 'Deputy Head Credit Department']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកលក់ឥណទានឌីជីថល','name_english' => 'Digital Lending Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកវាយតម្លៃឥណទានឌីជីថល','name_english' => 'Digital Assessment Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកលក់សាជីវកម្ម','name_english' => 'Corporate Sales Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកឥណទានយានយន្ត','name_english' => 'Auto Loan Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកផលប័ត្រឥណទាន','name_english' => 'Credit Portfolio Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកត្រួតពិនិត្យឥណទាន','name_english' => 'Credit Control Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកវិភាគឥណទាន','name_english' => 'Credit Underwriting Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកលក់ឥណទានខ្នាតតូច និងមធ្យម','name_english' => 'SME Lending Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកដោះស្រាយឥណទានយឺតយ៉ាវ','name_english' => 'Loan Recovery Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានគ្រប់គ្រងសាខា','name_english' => 'Branch Supervision Manager']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកលក់ឥណទានឌីជីថលជាន់ខ្ពស់','name_english' => 'Senior Digital Lending Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកផ្នែកវាយតម្លៃឥណទានឌីជីថលជាន់ខ្ពស់','name_english' => 'Senior Digital Loan Assessment Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកលក់សាជីវកម្មជាន់ខ្ពស់','name_english' => 'Senior Corporate Sales Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកឥណទានយានយន្តជាន់ខ្ពស់','name_english' => 'Senior Auto Loan Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកផ្នែកវាយតម្លៃឥណទានឌីជីថលជាន់ខ្ពស់','name_english' => 'Senior Assessment Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកផលប័ត្រឥណទានជាន់ខ្ពស់','name_english' => 'Senior Credit Portfolio Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកត្រួតពិនិត្យឥណទានជាន់ខ្ពស់','name_english' => 'Senior Credit Control Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកវិភាគឥណទានជាន់ខ្ពស់','name_english' => 'Senior Credit Underwriting Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកផ្នែកលក់ឥណទានខ្នាតតូច និងមធ្យមជាន់ខ្ពស់','name_english' => 'Senior SME Lending Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកដោះស្រាយឥណទានជាន់ខ្ពស់','name_english' => 'Senior Loan Recovery Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកលក់ឥណទានឌីជីថល','name_english' => 'Digital Lending Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកលក់សាជីវកម្ម','name_english' => 'Corporate Sales Officer']);
        Position::firstOrCreate(['name_khmer' => 'ភ្នាក់ងារឥណទានយានយន្ត','name_english' => 'Auto Loan Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិករដ្ឋបាលឥណទាន','name_english' => 'Credit Admin Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកត្រួតពិនិត្យឥណទាន','name_english' => 'Credit Control Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកវិភាគឥណទាន','name_english' => 'Credit Underwriting Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកផ្នែកលក់ឥណទានខ្នាតតូច និងមធ្យម','name_english' => 'SME Lending Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកដោះស្រាយឥណទាន','name_english' => 'Loan Recovery Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកឥណទានយានយន្តថ្មី','name_english' => 'Junior Auto Loan Officer']);
        Position::firstOrCreate(['name_khmer' => 'នាយក នាយកដ្ឋានទីផ្សារ និងអភិវឌ្ឍន៍ផលិតផល','name_english' => 'Head of Marketing and Product Development Department']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកអភិវឌ្ឍន៍ផលិតផល','name_english' => 'Product Development Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែកទីផ្សារឌីជីថល','name_english' => 'Digital Marketing Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានផ្នែករចនាក្រហ្វិក','name_english' => 'Creative Design Unit Manager']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកស្រាវជ្រាវផ្នែកទីផ្សារជាន់ខ្ពស់','name_english' => 'Senior Marketing Research Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកអភិវឌ្ឍន៍ផលិតផលជាន់ខ្ពស់','name_english' => 'Senior Product Development Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកឯកទេសទីផ្សារឌីជីថល','name_english' => 'Digital Marketing Specialist']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិករចនាក្រហ្វិកជាន់ខ្ពស់','name_english' => 'Senior Creative Designer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកអភិវឌ្ឍន៍គោលនយោបាយឥណទានជាន់ខ្ពស់','name_english' => 'Senior Policy Development Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកបម្រើសេវា និងទំនាក់ទំនងអតិថជនជាន់ខ្ពស់','name_english' => 'Senior Customer Service Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកអភិវឌ្ឍន៍ផលិតផល','name_english' => 'Product Development Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកបម្រើសេវា និងទំនាក់ទំនងអតិថជន','name_english' => 'Customer Service Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិករចនាក្រាហ្វិក','name_english' => 'Creative Designer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិកអភិវឌ្ឍន៍គោលនយោបាយឥណទាន','name_english' => 'Policy Development Officer']);
        Position::firstOrCreate(['name_khmer' => 'នាយក នាយកដ្ឋានប្រតិបត្តិតាម','name_english' => 'Head of Compliance Department']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានមុខងារប្រតិបត្តិតាម','name_english' => 'Compliance Manager']);
        Position::firstOrCreate(['name_khmer' => 'មន្រ្តីប្រតិបត្តិតាម','name_english' => 'Compliance Officer']);
        Position::firstOrCreate(['name_khmer' => 'នាយក​ ការរិយាល័យប្រតិបត្តិការ','name_english' => 'Operation Manager']);
        Position::firstOrCreate(['name_khmer' => 'នាយក​ សាខា','name_english' => 'Branch Manager']);
        Position::firstOrCreate(['name_khmer' => 'នាយករង ការិយាល័យប្រតិបត្តិការ','name_english' => 'Deputy Operation Manager']);
        Position::firstOrCreate(['name_khmer' => 'នាយក​រង សាខា','name_english' => 'Deputy Branch Manager']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានភ្នាក់ងារឥណទាន','name_english' => 'Chief Credit Officer','type'=>'Credit_Officer']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានគណនេយ្យករប្រតិបត្តិការ','name_english' => 'Chief Operation Accountant']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានគណនេយ្យករសាខា','name_english' => 'Chief Branch Accountant']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានបេឡាករ','name_english' => 'Chief Teller']);
        Position::firstOrCreate(['name_khmer' => 'ប្រធានក្រុមបេឡករ','name_english' => 'Teller Team Leader']);
        Position::firstOrCreate(['name_khmer' => 'ភ្នាក់ងារឥណទានជាន់ខ្ពស់','name_english' => 'Senior Credit Officer','type'=>'Credit_Officer']);
        Position::firstOrCreate(['name_khmer' => 'គណនេយ្យករប្រតិបត្តិការជាន់ខ្ពស់','name_english' => 'Senior Operation Accountant']);
        Position::firstOrCreate(['name_khmer' => 'គណនេយ្យករសាខាជាន់ខ្ពស់','name_english' => 'Senior Branch Accountant']);
        Position::firstOrCreate(['name_khmer' => 'ភ្នាក់ងារឥណទាន','name_english' => 'Credit Officer','type'=>'Credit_Officer']);
        Position::firstOrCreate(['name_khmer' => 'បុគ្គលិករដ្ឋបាលឥណទាន','name_english' => 'Credit Admin Officer']);
        Position::firstOrCreate(['name_khmer' => 'គណនេយ្យករប្រតិបត្តិការ','name_english' => 'Operation Accountant']);
        Position::firstOrCreate(['name_khmer' => 'គណនេយ្យករសាខា','name_english' => 'Branch Accountant']);
        Position::firstOrCreate(['name_khmer' => 'បេឡាករជាន់ខ្ពស់','name_english' => 'Senior Teller']);
        Position::firstOrCreate(['name_khmer' => 'បេឡាករ​','name_english' => 'Teller']);
    }
}
