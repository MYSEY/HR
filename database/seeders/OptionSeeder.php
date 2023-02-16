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
            'name_khmer' => 'Economics and Management',
            'name_english'=>'Economics and Management',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Business Analytics',
            'name_english'=>'Business Analytics',
            'type' => 'field_of_study',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Master Degree',
            'name_english'=>'Master Degree',
            'type' => 'degree',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Bachelor degree',
            'name_english'=>'Bachelor degree',
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
            'name_khmer' => 'female',
            'name_english'=>'female',
            'type' => 'gender',
            'created_by'    => Auth::id(),
        ]);
        Option::firstOrCreate([
            'name_khmer' => 'Other',
            'name_english'=>'Other',
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
    }
}
