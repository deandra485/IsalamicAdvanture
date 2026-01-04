<?php

// database/seeders/HikingRouteSeeder.php
namespace Database\Seeders;

use App\Models\HikingRoute;
use Illuminate\Database\Seeder;

class HikingRouteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            // Semeru Routes
            [
                'mountain_id' => 1,
                'nama_jalur' => 'Jalur Ranu Pane',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 4,
                'jarak_km' => 24.5,
                'deskripsi_jalur' => 'Jalur utama menuju puncak Mahameru via Ranu Kumbolo.',
                'is_available' => true,
            ],
            // Rinjani Routes
            [
                'mountain_id' => 2,
                'nama_jalur' => 'Jalur Senaru',
                'tingkat_kesulitan' => 'sangat sulit',
                'estimasi_waktu_hari' => 3,
                'jarak_km' => 22.0,
                'deskripsi_jalur' => 'Jalur populer dengan pemandangan air terjun dan danau Segara Anak.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 2,
                'nama_jalur' => 'Jalur Sembalun',
                'tingkat_kesulitan' => 'sangat sulit',
                'estimasi_waktu_hari' => 3,
                'jarak_km' => 20.0,
                'deskripsi_jalur' => 'Jalur lebih terbuka dengan padang savana yang luas.',
                'is_available' => true,
            ],
            // Merbabu Routes
            [
                'mountain_id' => 3,
                'nama_jalur' => 'Jalur Selo',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 9.5,
                'deskripsi_jalur' => 'Jalur paling populer dengan medan yang relatif landai.',
                'is_available' => true,
            ],
            // Prau Routes
            [
                'mountain_id' => 4,
                'nama_jalur' => 'Jalur Patak Banteng',
                'tingkat_kesulitan' => 'mudah',
                'estimasi_waktu_hari' => 1,
                'jarak_km' => 3.5,
                'deskripsi_jalur' => 'Jalur pendek ideal untuk pemula dengan pemandangan savana.',
                'is_available' => true,
            ],
        ];

        foreach ($routes as $route) {
            HikingRoute::create($route);
        }
    }
}
