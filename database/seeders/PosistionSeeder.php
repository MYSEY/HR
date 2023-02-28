<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

class PosistionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=PosistionSeeder
     *
     * @return void
     */
    public function run()
    {
        Position::firstOrCreate(['name_khmer' => 'Web Development','name_english' => 'Web Development']);
    }
}
