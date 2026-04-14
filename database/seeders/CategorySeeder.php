<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = ['Coffee', 'Non-Coffee', 'Food', 'Snack'];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
