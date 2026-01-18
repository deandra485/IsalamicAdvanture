<?php

namespace Database\Seeders;

use App\Models\HikingRoute;
use Illuminate\Database\Seeder;

class HikingRouteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            // ===========================
            // JAWA BARAT (ID 1-3)
            // ===========================

            // 1. Gunung Gede
            [
                'mountain_id' => 1,
                'nama_jalur' => 'Jalur Cibodas',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.5,
                'deskripsi_jalur' => 'Jalur populer melewati Telaga Biru dan Air Terjun Cibeureum, didominasi tangga batu.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 1,
                'nama_jalur' => 'Jalur Putri',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 8.0,
                'deskripsi_jalur' => 'Jalur lebih pendek namun terjal dengan dominasi akar pepohonan.',
                'is_available' => true,
            ],

            // 2. Gunung Papandayan
            [
                'mountain_id' => 2,
                'nama_jalur' => 'Jalur Camp David',
                'tingkat_kesulitan' => 'mudah',
                'estimasi_waktu_hari' => 1,
                'jarak_km' => 6.5,
                'deskripsi_jalur' => 'Cocok untuk pemula dan wisata keluarga, melewati kawah aktif dan Hutan Mati.',
                'is_available' => true,
            ],

            // 3. Gunung Ciremai
            [
                'mountain_id' => 3,
                'nama_jalur' => 'Jalur Apuy',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 12.0,
                'deskripsi_jalur' => 'Jalur favorit via Majalengka, trek cukup terjal namun pemandangan terbuka.',
                'is_available' => true,
            ],

            // ===========================
            // JAWA TENGAH (ID 4-8)
            // ===========================

            // 4. Gunung Merbabu
            [
                'mountain_id' => 4,
                'nama_jalur' => 'Jalur Selo',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 9.5,
                'deskripsi_jalur' => 'Jalur paling populer dengan pemandangan sabana yang indah dan trek tanah.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 4,
                'nama_jalur' => 'Jalur Suwanting',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.0,
                'deskripsi_jalur' => 'Trek menantang dengan sumber air melimpah dan pemandangan hutan pinus.',
                'is_available' => true,
            ],

            // 5. Gunung Prau
            [
                'mountain_id' => 5,
                'nama_jalur' => 'Jalur Patak Banteng',
                'tingkat_kesulitan' => 'mudah',
                'estimasi_waktu_hari' => 1,
                'jarak_km' => 3.5,
                'deskripsi_jalur' => 'Jalur pendek, cepat, dan sangat ramai. Terkenal dengan spot Golden Sunrise.',
                'is_available' => true,
            ],

            // 6. Gunung Slamet
            [
                'mountain_id' => 6,
                'nama_jalur' => 'Jalur Bambangan',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 11.0,
                'deskripsi_jalur' => 'Gerbang utama atap Jawa Tengah via Purbalingga, trek tanah merah panjang.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 6,
                'nama_jalur' => 'Jalur Permadi Guci', // <--- TAMBAHAN BARU
                'tingkat_kesulitan' => 'sedang', // Relatif lebih landai dibanding Bambangan
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.5,
                'deskripsi_jalur' => 'Start dari wisata Guci Tegal, jalur terkenal dengan hutan asri dan trek yang relatif lebih landai.',
                'is_available' => true,
            ],

            // 7. Gunung Sumbing
            [
                'mountain_id' => 7,
                'nama_jalur' => 'Jalur Garung',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 9.0,
                'deskripsi_jalur' => 'Jalur populer via Wonosobo. Trek batu tersusun rapi namun sangat terjal.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 7,
                'nama_jalur' => 'Jalur Kaliangkrik (Adipuro)',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.5,
                'deskripsi_jalur' => 'Jalur via Magelang, trek relatif lebih landai dibanding Garung namun lebih panjang.',
                'is_available' => true,
            ],

            // 8. Gunung Sindoro
            [
                'mountain_id' => 8,
                'nama_jalur' => 'Jalur Kledung',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 7.5,
                'deskripsi_jalur' => 'Basecamp di pinggir jalan raya, pemandangan Gunung Sumbing terlihat jelas.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 8,
                'nama_jalur' => 'Jalur Alang-Alang Sewu',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 8.5,
                'deskripsi_jalur' => 'Jalur via Wonosobo, trek cukup terjal namun sunyi dan alami.',
                'is_available' => true,
            ],

            // ===========================
            // LOMBOK (ID 9)
            // ===========================

            // 9. Gunung Rinjani
            [
                'mountain_id' => 9,
                'nama_jalur' => 'Jalur Sembalun',
                'tingkat_kesulitan' => 'sangat sulit',
                'estimasi_waktu_hari' => 3, // Biasanya 3-4 hari
                'jarak_km' => 20.0,
                'deskripsi_jalur' => 'Jalur padang savana terbuka, rute utama untuk mengejar puncak (summit attack).',
                'is_available' => true,
            ],
            [
                'mountain_id' => 9,
                'nama_jalur' => 'Jalur Senaru',
                'tingkat_kesulitan' => 'sangat sulit',
                'estimasi_waktu_hari' => 3,
                'jarak_km' => 22.0,
                'deskripsi_jalur' => 'Start dari hutan tropis, biasanya digunakan untuk rute turun ke Danau Segara Anak.',
                'is_available' => true,
            ],
        ];

        foreach ($routes as $route) {
            HikingRoute::create($route);
        }
    }
}