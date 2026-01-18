<?php

namespace Database\Seeders;

use App\Models\Mountain;
use Illuminate\Database\Seeder;

class MountainSeeder extends Seeder
{
    public function run(): void
    {
        $mountains = [
            // ===========================
            // JAWA BARAT (ID 1 - 3)
            // ===========================
            [
                'nama_gunung' => 'Gunung Gede',
                'lokasi' => 'Jawa Barat',
                'ketinggian' => 2958,
                'tingkat_kesulitan' => 'sedang',
                'deskripsi' => 'Bagian dari Taman Nasional Gede Pangrango, terkenal dengan Alun-alun Surya Kencana.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Papandayan',
                'lokasi' => 'Jawa Barat',
                'ketinggian' => 2665,
                'tingkat_kesulitan' => 'mudah',
                'deskripsi' => 'Gunung wisata dengan kawah aktif yang mudah dijangkau dan Hutan Mati yang eksotis.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Ciremai',
                'lokasi' => 'Jawa Barat',
                'ketinggian' => 3078,
                'tingkat_kesulitan' => 'sulit',
                'deskripsi' => 'Gunung tertinggi di Jawa Barat, memiliki kawah ganda dan tanjakan yang panjang.',
                'is_active' => true,
                'created_by' => 1,
            ],

            // ===========================
            // JAWA TENGAH (ID 4 - 8)
            // ===========================
            [
                'nama_gunung' => 'Gunung Merbabu',
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 3145,
                'tingkat_kesulitan' => 'sedang',
                'deskripsi' => 'Terkenal dengan padang sabana yang sangat luas dan pemandangan Gunung Merapi yang megah.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Prau',
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 2565,
                'tingkat_kesulitan' => 'mudah',
                'deskripsi' => 'Spot terbaik melihat Golden Sunrise dengan latar belakang Sindoro-Sumbing.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Slamet',
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 3428,
                'tingkat_kesulitan' => 'sulit',
                'deskripsi' => 'Atap Jawa Tengah. Gunung tunggal yang besar dengan medan pasir berbatu di puncak.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Sumbing',
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 3371,
                'tingkat_kesulitan' => 'sulit',
                'deskripsi' => 'Gunung tertinggi kedua di Jateng, trek menantang dengan formasi kawah yang unik.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Sindoro',
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 3153,
                'tingkat_kesulitan' => 'sedang',
                'deskripsi' => 'Gunung berapi aktif dengan kawah belerang yang indah, tetangga Gunung Sumbing.',
                'is_active' => true,
                'created_by' => 1,
            ],

            // ===========================
            // LOMBOK (ID 9)
            // ===========================
            [
                'nama_gunung' => 'Gunung Rinjani',
                'lokasi' => 'Lombok, NTB',
                'ketinggian' => 3726,
                'tingkat_kesulitan' => 'sangat sulit',
                'deskripsi' => 'Gunung berapi aktif dengan kaldera raksasa dan Danau Segara Anak yang menakjubkan.',
                'is_active' => true,
                'created_by' => 1,
            ],
        ];

        foreach ($mountains as $mountain) {
            Mountain::create($mountain);
        }
    }
}