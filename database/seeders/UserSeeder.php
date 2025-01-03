<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'admin',
            'email' => 'admin@mailinator.com',
            'password' => Hash::make('123'),
            'mobile_no' => 1234567890,
            'city_id' => 1,
            'status'=>config('site.status.approved'),
            'role_id'=>config('site.roles.admin'),
        ]);
    }
}
