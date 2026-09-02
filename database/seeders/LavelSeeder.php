<?php

namespace Database\Seeders;

use App\Models\Lavel;
use App\Models\Department;
use Illuminate\Database\Seeder;

class LavelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=LavelSeeder
     *
     * @return void
     */
    public function run()
    {
        Lavel::firstOrCreate([
            "name"=> "Level 12",
        ]);
        Lavel::firstOrCreate([
            "name"=> "Level 11",
        ]);
        Lavel::firstOrCreate([
            "name"=> "Level 10",
        ]);
        Lavel::firstOrCreate([
            "name"=> "Level 9",
        ]);
        Lavel::firstOrCreate([
            "name"=> "Level 8",
        ]);
        Lavel::firstOrCreate([
            "name"=> "Level 7",
        ]);
        Lavel::firstOrCreate([
            "name"=> "Level 6",
        ]);
        Lavel::firstOrCreate([
            "name"=> "Level 5A",
        ]);
        Lavel::firstOrCreate([
            "name"=> "Level 5B",
        ]);
        Lavel::firstOrCreate([
            "name"=> "Level 4A",
        ]);
        Lavel::firstOrCreate([
            "name"=> "Level 4B",
        ]);
        Lavel::firstOrCreate([
            "name"=> "Level 3",
        ]);
        Lavel::firstOrCreate([
            "name"=> "Level 2",
        ]);
        Lavel::firstOrCreate([
            "name"=> "Level 1",
        ]);
    }
}
