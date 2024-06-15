<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // id = 1
        Category::create([
            'title' => 'Programming',
            'seotitle' => 'Programming',
            'slug' => 'programming',
            'active' => 'Yes'
        ]);

        // id = 2
        Category::create([
            'title' => 'UI / UX',
            'seotitle' => 'UI / UX',
            'slug' => 'ui-ux',
            'active' => 'Yes'
            
        ]);

        // id = 3
        Category::create([
            'title' => 'DevOps',
            'seotitle' => 'DevOps',
            'slug' => 'devops',
            'active' => 'Yes'
        ]);
    }
}
