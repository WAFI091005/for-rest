<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Article;
use App\Models\Tag;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $articles = [
            [
                'data' => [
                    'title' => 'Fajar di Gunung Rinjani',
                    'author' => 'Sarah Johnson',
                    'author_image' => '/api/placeholder/100/100',
                    'location' => 'Taman Nasional Gunung Rinjani, Lombok, Indonesia',
                    'trip_date' => '2022-12-12',
                    'image' => '/assets/img/rinjani.jpg',
                    'excerpt' => 'Foto ini diambil saat perjalanan mendaki Gunung Rinjani selama 3 hari di Lombok, Indonesia...',
                    'content' => '<p>Foto ini diambil saat...</p>',
                    'category_id' => 1,
                ],
                'tags' => ['Pendakian', 'Gunung', 'Fajar'],
            ],
            [
                'data' => [
                    'title' => 'Mendaki Gunung Semeru',
                    'author' => 'John Doe',
                    'author_image' => '/api/placeholder/100/100',
                    'location' => 'Taman Nasional Bromo Tengger Semeru, Jawa Timur, Indonesia',
                    'trip_date' => '2023-06-01',
                    'image' => '/assets/img/mountain.jpg',
                    'excerpt' => 'Petualangan mendaki Gunung Semeru, puncak tertinggi di Jawa Timur, dengan pemandangan luar biasa...',
                    'content' => '<p>Pengalaman luar biasa saat mendaki Semeru...</p>',
                    'category_id' => 2,
                ],
                'tags' => ['Pantai', 'Jawa Tengah', 'Karimun'],
            ],
            [
                'data' => [
                    'title' => 'Eksplorasi Hutan Kalimantan',
                    'author' => 'Michael Lee',
                    'author_image' => '/api/placeholder/100/100',
                    'location' => 'Kalimantan, Indonesia',
                    'trip_date' => '2023-09-15',
                    'image' => '/assets/img/forest.jpg',
                    'excerpt' => 'Menjelajahi hutan tropis Kalimantan dengan keanekaragaman hayati yang luar biasa...',
                    'content' => '<p>Petualangan ini membawa saya ke dalam hutan lebat Kalimantan...</p>',
                    'category_id' => 3,
                ],
                'tags' => ['Hutan', 'Eksplorasi', 'Kalimantan'],
            ]
        ];

        foreach ($articles as $articleItem) {
            $article = Article::updateOrCreate(
                ['title' => $articleItem['data']['title']],
                $articleItem['data']
            );

            $tagIds = [];
            foreach ($articleItem['tags'] as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }

            // Sink agar tidak menambahkan duplikat attach
            $article->tags()->sync($tagIds);
        }
    }
}
