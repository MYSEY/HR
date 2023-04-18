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
        Position::firstOrCreate(['name_khmer' => 'Web Development','name_english' => 'Web Development']);
    }
}
