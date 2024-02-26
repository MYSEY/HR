<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * php artisan db:seed --class=RoleSeeder
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert(
            [
                [
                    'role_name'=>'Admin',
                    'role_type'=>'admin',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ],
                [
                    'role_name'=>'Developer',
                    'role_type'=>'developer',
                    'status'=>1,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]
            ]
        );
    }
}
