<?php

namespace Database\Seeders;

use App\Models\HikingRoute;
use Illuminate\Database\Seeder;

class HikingRouteSeeder extends Seeder
{
    public function run(): void
    {
        // Urutan ID akan mengikuti urutan array ini (Auto Increment DB)
        $routes = [
            // ===========================
            // 1. GUNUNG GEDE
            // ===========================
            [
                'mountain_id' => 1,
                'nama_jalur' => 'Jalur Cibodas',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.5,
                'deskripsi_jalur' => 'Jalur populer melewati Telaga Biru dan Air Terjun Cibeureum, didominasi tangga batu.',
                'is_available' => true,
            ], // ID: 1
            [
                'mountain_id' => 1,
                'nama_jalur' => 'Jalur Putri',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 8.0,
                'deskripsi_jalur' => 'Jalur lebih pendek namun terjal dengan dominasi akar pepohonan (dengkul ketemu dagu).',
                'is_available' => true,
            ], // ID: 2
            [
                'mountain_id' => 1,
                'nama_jalur' => 'Jalur Selabintana',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 12.5,
                'deskripsi_jalur' => 'Jalur terpanjang dan terliar via Sukabumi, banyak pacet dan lumpur.',
                'is_available' => true,
            ], // ID: 3

            // ===========================
            // 2. GUNUNG PAPANDAYAN
            // ===========================
            [
                'mountain_id' => 2,
                'nama_jalur' => 'Jalur Camp David',
                'tingkat_kesulitan' => 'mudah',
                'estimasi_waktu_hari' => 1,
                'jarak_km' => 6.5,
                'deskripsi_jalur' => 'Cocok untuk pemula dan wisata keluarga, melewati kawah aktif dan Hutan Mati.',
                'is_available' => true,
            ], // ID: 4

            // ===========================
            // 3. GUNUNG CIREMAI
            // ===========================
            [
                'mountain_id' => 3,
                'nama_jalur' => 'Jalur Apuy',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.0,
                'deskripsi_jalur' => 'Jalur via Majalengka, trek terjal namun waktu tempuh relatif lebih singkat.',
                'is_available' => true,
            ], // ID: 5
            [
                'mountain_id' => 3,
                'nama_jalur' => 'Jalur Palutungan',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 11.5,
                'deskripsi_jalur' => 'Jalur via Kuningan, trek landai dan panjang, banyak sumber air di pos awal.',
                'is_available' => true,
            ], // ID: 6
            [
                'mountain_id' => 3,
                'nama_jalur' => 'Jalur Linggarjati',
                'tingkat_kesulitan' => 'sangat sulit',
                'estimasi_waktu_hari' => 3, // Biasanya butuh waktu lebih lama
                'jarak_km' => 14.0,
                'deskripsi_jalur' => 'Jalur legendaris dengan tanjakan "Bapak Tere", sangat menguras fisik.',
                'is_available' => true,
            ], // ID: 7

            // ===========================
            // 4. GUNUNG MERBABU
            // ===========================
            [
                'mountain_id' => 4,
                'nama_jalur' => 'Jalur Selo',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 9.5,
                'deskripsi_jalur' => 'Jalur sejuta umat, pemandangan sabana indah, tidak ada sumber air.',
                'is_available' => true,
            ], // ID: 8
            [
                'mountain_id' => 4,
                'nama_jalur' => 'Jalur Suwanting',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.0,
                'deskripsi_jalur' => 'View premium namun trek sangat menantang dan debu tebal saat kemarau.',
                'is_available' => true,
            ], // ID: 9
            [
                'mountain_id' => 4,
                'nama_jalur' => 'Jalur Wekas',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 8.5,
                'deskripsi_jalur' => 'Jalur tercepat mencapai pos pemancar, sumber air melimpah di Pos 2.',
                'is_available' => true,
            ], // ID: 10

            // ===========================
            // 5. GUNUNG PRAU
            // ===========================
            [
                'mountain_id' => 5,
                'nama_jalur' => 'Jalur Patak Banteng',
                'tingkat_kesulitan' => 'mudah',
                'estimasi_waktu_hari' => 1,
                'jarak_km' => 3.5,
                'deskripsi_jalur' => 'Jalur sangat curam tapi sangat cepat sampai puncak (2-3 jam).',
                'is_available' => true,
            ], // ID: 11
            [
                'mountain_id' => 5,
                'nama_jalur' => 'Jalur Dieng (Dwarawati)',
                'tingkat_kesulitan' => 'mudah',
                'estimasi_waktu_hari' => 1,
                'jarak_km' => 4.5,
                'deskripsi_jalur' => 'Jalur lebih landai dan santai, cocok untuk keluarga, start dari area Candi.',
                'is_available' => true,
            ], // ID: 12

            // ===========================
            // 6. GUNUNG SLAMET
            // ===========================
            [
                'mountain_id' => 6,
                'nama_jalur' => 'Jalur Bambangan',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 11.0,
                'deskripsi_jalur' => 'Gerbang utama atap Jawa Tengah, trek tanah merah licin saat hujan.',
                'is_available' => true,
            ], // ID: 13
            [
                'mountain_id' => 6,
                'nama_jalur' => 'Jalur Permadi Guci',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.5,
                'deskripsi_jalur' => 'Bonus mandi air panas Guci setelah turun, trek hutan asri.',
                'is_available' => true,
            ], // ID: 14

            // ===========================
            // 7. GUNUNG SUMBING
            // ===========================
            [
                'mountain_id' => 7,
                'nama_jalur' => 'Jalur Garung',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 9.0,
                'deskripsi_jalur' => 'Jalur sejuta umat, trek batu (pestisida) dan tanjakan engkol-engkolan.',
                'is_available' => true,
            ], // ID: 15
            [
                'mountain_id' => 7,
                'nama_jalur' => 'Jalur Kaliangkrik (Adipuro)',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.5,
                'deskripsi_jalur' => 'Start dari Nepal van Java, pemandangan desa sangat indah.',
                'is_available' => true,
            ], // ID: 16

            // ===========================
            // 8. GUNUNG SINDORO
            // ===========================
            [
                'mountain_id' => 8,
                'nama_jalur' => 'Jalur Kledung',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 7.5,
                'deskripsi_jalur' => 'Paling populer, akses mudah di pinggir jalan raya provinsi.',
                'is_available' => true,
            ], // ID: 17
            [
                'mountain_id' => 8,
                'nama_jalur' => 'Jalur Alang-Alang Sewu',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 8.5,
                'deskripsi_jalur' => 'Jalur sunyi, vegetasi rapat dan alami.',
                'is_available' => true,
            ], // ID: 18

            // ===========================
            // 9. GUNUNG RINJANI
            // ===========================
            [
                'mountain_id' => 9,
                'nama_jalur' => 'Jalur Sembalun',
                'tingkat_kesulitan' => 'sangat sulit',
                'estimasi_waktu_hari' => 3,
                'jarak_km' => 20.0,
                'deskripsi_jalur' => 'Rute padang savana, akses utama menuju Puncak (Summit).',
                'is_available' => true,
            ], // ID: 19
            [
                'mountain_id' => 9,
                'nama_jalur' => 'Jalur Senaru',
                'tingkat_kesulitan' => 'sangat sulit',
                'estimasi_waktu_hari' => 3,
                'jarak_km' => 22.0,
                'deskripsi_jalur' => 'Rute hutan tropis, akses utama menuju Danau Segara Anak.',
                'is_available' => true,
            ], // ID: 20
            [
                'mountain_id' => 9,
                'nama_jalur' => 'Jalur Torean',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 3,
                'jarak_km' => 18.0,
                'deskripsi_jalur' => 'Jalur "Jurassic Park", menyusuri lembah sungai putih dan tebing eksotis.',
                'is_available' => true,
            ], // ID: 21
        ];

        foreach ($routes as $route) {
            HikingRoute::create($route);
        }
    }
}