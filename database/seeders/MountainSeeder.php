<?php

// database/seeders/MountainSeeder.php
namespace Database\Seeders;

use App\Models\Mountain;
use Illuminate\Database\Seeder;

class MountainSeeder extends Seeder
{
    public function run(): void
    {
        $mountains = [
            [
                'nama_gunung' => 'Gunung Semeru',
                'lokasi' => 'Jawa Timur',
                'ketinggian' => 3676,
                'tingkat_kesulitan' => 'sulit',
                'deskripsi' => 'Gunung tertinggi di Pulau Jawa dengan pemandangan yang spektakuler.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Rinjani',
                'lokasi' => 'Lombok, NTB',
                'ketinggian' => 3726,
                'tingkat_kesulitan' => 'sangat sulit',
                'deskripsi' => 'Gunung berapi aktif dengan danau kawah Segara Anak yang menakjubkan.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Merbabu',
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 3145,
                'tingkat_kesulitan' => 'sedang',
                'deskripsi' => 'Gunung dengan jalur pendakian yang ramah pemula dengan view sunrise yang indah.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Prau',
                'lokasi' => 'Jawa Tengah',
                'ketinggian' => 2565,
                'tingkat_kesulitan' => 'mudah',
                'deskripsi' => 'Gunung ideal untuk pemula dengan padang savana yang luas.',
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'nama_gunung' => 'Gunung Gede Pangrango',
                'lokasi' => 'Jawa Barat',
                'ketinggian' => 2958,
                'tingkat_kesulitan' => 'sedang',
                'deskripsi' => 'Gunung kembar dengan jalur tracking yang menantang dan vegetasi yang beragam.',
                'is_active' => true,
                'created_by' => 1,
            ],
        ];

        foreach ($mountains as $mountain) {
            Mountain::create($mountain);
        }
    }
}
