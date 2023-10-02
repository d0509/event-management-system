<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{

    public function run(): void
    {
        Category::insert([
            ['name' => config('site.categories.corporate')],
            ['name' => config('site.categories.social')],
            ['name' => config('site.categories.cultural')],
            ['name' => config('site.categories.musical')],
            ['name' => config('site.categories.technical')]
        ]);
    }
}
