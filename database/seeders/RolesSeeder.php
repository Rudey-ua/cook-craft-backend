<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = Config::get('permission.user_roles');
        foreach ($roles as $key => $value) {
            Role::create(['name' => $key]);
        }
    }
}
