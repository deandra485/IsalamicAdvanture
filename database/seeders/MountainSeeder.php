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
            // JAWA BARAT (ID 1 - 3 & 10)
            // ===========================
            [
                'nama_gunung' => 'Gunung Gede', // ID 1
                'lokasi' => 'Jawa Barat',
                'ketinggian' => 2958,
                'tingkat_kesulitan' => 'sedang',
                'deskripsi' => 'Bagian dari Taman Nasional Gede Pangrango, terkenal dengan Alun-alun Surya Kencana.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Papandayan', // ID 2
                'lokasi' => 'Jawa Barat',
                'ketinggian' => 2665,
                'tingkat_kesulitan' => 'mudah',
                'deskripsi' => 'Gunung wisata dengan kawah aktif yang mudah dijangkau dan Hutan Mati yang eksotis.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Ciremai', // ID 3
                'lokasi' => 'Jawa Barat',
                'ketinggian' => 3078,
                'tingkat_kesulitan' => 'sulit',
                'deskripsi' => 'Gunung tertinggi di Jawa Barat, memiliki kawah ganda dan tanjakan yang panjang.',
                'is_active' => true,
                'created_by' => 1,
            ],
            // --- TAMBAHAN BARU ---
            [
                'nama_gunung' => 'Gunung Cikuray', // ID 10
                'lokasi' => 'Jawa Barat',
                'ketinggian' => 2821,
                'tingkat_kesulitan' => 'sulit',
                'deskripsi' => 'Gunung berbentuk kerucut sempurna di Garut, terkenal dengan lautan awan dan trek yang terjal.',
                'is_active' => true,
                'created_by' => 1,
            ],

            // ===========================
            // JAWA TENGAH (ID 4 - 8 & 11-14)
            // ===========================
            [
                'nama_gunung' => 'Gunung Merbabu', // ID 4
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 3145,
                'tingkat_kesulitan' => 'sedang',
                'deskripsi' => 'Terkenal dengan padang sabana yang sangat luas dan pemandangan Gunung Merapi yang megah.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Prau', // ID 5
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 2565,
                'tingkat_kesulitan' => 'mudah',
                'deskripsi' => 'Spot terbaik melihat Golden Sunrise dengan latar belakang Sindoro-Sumbing.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Slamet', // ID 6
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 3428,
                'tingkat_kesulitan' => 'sulit',
                'deskripsi' => 'Atap Jawa Tengah. Gunung tunggal yang besar dengan medan pasir berbatu di puncak.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Sumbing', // ID 7
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 3371,
                'tingkat_kesulitan' => 'sulit',
                'deskripsi' => 'Gunung tertinggi kedua di Jateng, trek menantang dengan formasi kawah yang unik.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Sindoro', // ID 8
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 3153,
                'tingkat_kesulitan' => 'sedang',
                'deskripsi' => 'Gunung berapi aktif dengan kawah belerang yang indah, tetangga Gunung Sumbing.',
                'is_active' => true,
                'created_by' => 1,
            ],
            // --- TAMBAHAN BARU ---
            [
                'nama_gunung' => 'Gunung Kembang', // ID 11
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 2340,
                'tingkat_kesulitan' => 'sedang',
                'deskripsi' => 'Sering disebut Anak Sindoro, trek pendek namun menanjak terus, view sangat indah.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Ungaran', // ID 12
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 2050,
                'tingkat_kesulitan' => 'mudah',
                'deskripsi' => 'Cocok untuk pendaki pemula, memiliki situs bersejarah Candi Gedong Songo.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Bismo', // ID 13
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 2365,
                'tingkat_kesulitan' => 'sedang',
                'deskripsi' => 'Gunung dengan jalur punggungan yang mempesona di dataran tinggi Dieng.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Lawu', // ID 14
                'lokasi' => 'Jawa Tengah/Timur',
                'ketinggian' => 3265,
                'tingkat_kesulitan' => 'sedang',
                'deskripsi' => 'Gunung mistis dengan warung tertinggi di Indonesia (Mbok Yem) di dekat puncak.',
                'is_active' => true,
                'created_by' => 1,
            ],

            // ===========================
            // LUAR JAWA (ID 9 & 15)
            // ===========================
            [
                'nama_gunung' => 'Gunung Rinjani', // ID 9
                'lokasi' => 'Lombok, NTB',
                'ketinggian' => 3726,
                'tingkat_kesulitan' => 'sangat sulit',
                'deskripsi' => 'Gunung berapi aktif dengan kaldera raksasa dan Danau Segara Anak yang menakjubkan.',
                'is_active' => true,
                'created_by' => 1,
            ],
            // --- TAMBAHAN BARU ---
            [
                'nama_gunung' => 'Gunung Kerinci', // ID 15
                'lokasi' => 'Jambi, Sumatra',
                'ketinggian' => 3805,
                'tingkat_kesulitan' => 'sulit',
                'deskripsi' => 'Atap Sumatera dan gunung berapi tertinggi di Indonesia, habitat Harimau Sumatera.',
                'is_active' => true,
                'created_by' => 1,
            ],
        ];

        foreach ($mountains as $mountain) {
            Mountain::create($mountain);
        }
    }
}