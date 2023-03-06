<?php

namespace App\Traits\RolePermissions;

use App\Traits\RolePermissions\RoleTrait;
use Backpack\PermissionManager\app\Models\Permission;

trait PermissionTrait
{
    use RoleTrait;

    // *** User
    public function user($seed = false)
    {
        if ($seed) {
            Permission::firstOrCreate(['name' => 'list user'])->roles()->sync([
                $this->roles('developer'), $this->roles('admin'), $this->roles('loan'), $this->roles('trading')
            ]);
            Permission::firstOrCreate(['name' => 'create user'])->roles()->sync([
                $this->roles('developer'), $this->roles('admin'), $this->roles('loan'), $this->roles('trading')
            ]);
        }
    }
}
