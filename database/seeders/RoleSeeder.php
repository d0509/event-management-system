<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name'=>config('site.role_names.admin')],
            ['name'=>config('site.role_names.company')],
            ['name'=>config('site.role_names.user')]            
        ]);
    }
}
