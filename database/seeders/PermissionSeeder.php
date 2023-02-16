<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Traits\RolePermissions\PermissionTrait;

class PermissionSeeder extends Seeder
{
    use PermissionTrait;

    /**
     * Run the database seeds.
     * php artisan db:seed --class=PermissionSeeder
     *
     * @return void
     */
    public function run()
    {
        $this->user(false);

        $user = User::firstOrCreate([
            'email' => 'administrator@gmail.com',
        ], [
            'name' => 'Sey',
            'last_name' => 'Admin',
            'phone' => '+0889377310',
            'password' => Hash::make('admin@009')
        ]);
        $user->roles()->syncWithoutDetaching([
            $this->roles('admin'),
            $this->roles('developer')
        ]);
    }
}
