<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Forest',
                'image' => 'assets/img/forest.jpg',
                'memories_count' => 5
            ],
            [
                'name' => 'Mountain',
                'image' => 'assets/img/mountain.jpg',
                'memories_count' => 8
            ],
            [
                'name' => 'Rain Forest',
                'image' => 'assets/img/rainforest.jpg',
                'memories_count' => 3
            ],
            [
                'name' => 'Beach',
                'image' => 'assets/img/karimun.jpg',
                'memories_count' => 6
            ],
            [
                'name' => 'Waterfall',
                'image' => 'assets/img/waterfall.jpg',
                'memories_count' => 6
            ],
            [
                'name' => 'Mangrove Forest',
                'image' => 'assets/img/karimun.jpg',
                'memories_count' => 1
            ]
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']], // Cek berdasarkan name
                $category // Update jika sudah ada, insert jika belum
            );
        }
    }
}
