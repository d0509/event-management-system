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
            ['name'=>config('site.roles.admin')],
            ['name'=>config('site.roles.company')],
            ['name'=>config('site.roles.user')]            
        ]);
    }
}
